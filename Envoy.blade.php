@setup
require __DIR__.'/vendor/autoload.php';

$server = "stitcher.io";
$userAndServer = 'forge@'. $server;
$repository = "brendt/rfc-vote.git";
$baseDir = "/home/forge/rfc.stitcher.io";
$releasesDir = "{$baseDir}/releases";
$currentDir = "{$baseDir}/current";
$newReleaseName = date('Ymd-His');
$newReleaseDir = "{$releasesDir}/{$newReleaseName}";
$user = get_current_user();

function logMessage($message) {
return "echo '\033[32m" .$message. "\033[0m';\n";
}
@endsetup

@servers(['local' => '127.0.0.1', 'remote' => $userAndServer])

@macro('deploy')
startDeployment
cloneRepository
runComposer
runNpm
updateSymlinks
optimizeInstallation
backupDatabase
migrateDatabase
blessNewRelease
cleanOldReleases
finishDeploy
@endmacro

@macro('deploy-back')
startDeployment
setupPhp
cloneRepository
runComposer
updateSymlinks
optimizeInstallation
backupDatabase
migrateDatabase
blessNewRelease
cleanOldReleases
finishDeploy
@endmacro

@macro('deploy-front')
pullChanges
runNpmInCurrentDir
finishCodeDeploy
@endmacro

@macro('deploy-code')
pullChanges
finishCodeDeploy
@endmacro

@task('startDeployment', ['on' => 'local'])
{{ logMessage("🏃  Starting deployment...") }}
git checkout main
git pull origin main
@endtask

@task('cloneRepository', ['on' => 'remote'])
{{ logMessage("🌀  Cloning repository...") }}
[ -d {{ $releasesDir }} ] || mkdir {{ $releasesDir }};
cd {{ $releasesDir }};

# Create the release dir
mkdir {{ $newReleaseDir }};

# Clone the repo
eval `ssh-agent -s`
ssh-add -D
ssh-add ~/.ssh/id_rsa_rfc

git clone --depth 1 git@github.com:{{ $repository }} {{ $newReleaseName }}

# Configure sparse checkout
cd {{ $newReleaseDir }}
git config core.sparsecheckout true
echo "*" > .git/info/sparse-checkout
echo "!storage" >> .git/info/sparse-checkout
echo "!public/build" >> .git/info/sparse-checkout
git read-tree -mu HEAD

ssh-add -D

# Mark release
cd {{ $newReleaseDir }}
echo "{{ $newReleaseName }}" > public/release-name.txt
@endtask

@task('runComposer', ['on' => 'remote'])
{{ logMessage("🚚  Running Composer...") }}
cd {{ $newReleaseDir }};
composer install --prefer-dist --no-scripts --no-dev -o;
@endtask

@task('runNpm', ['on' => 'remote'])
{{ logMessage("📦  Running NPM...") }}
cd {{ $newReleaseDir }};
npm install
npm run build
@endtask

@task('runNpmInCurrentDir', ['on' => 'remote'])
{{ logMessage("📦  Running NPM...") }}
cd {{ $currentDir }};
npm install
npm run build
@endtask

@task('updateSymlinks', ['on' => 'remote'])
{{ logMessage("🔗  Updating symlinks to persistent data...") }}
# Remove the storage directory and replace with persistent data
rm -rf {{ $newReleaseDir }}/storage;
cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/persistent/storage storage;

# Import the environment config
cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/.env .env;
@endtask

@task('optimizeInstallation', ['on' => 'remote'])
{{ logMessage("✨  Optimizing installation...") }}
cd {{ $newReleaseDir }};
php8.3 artisan clear-compiled;
@endtask

@task('backupDatabase', ['on' => 'remote'])
{{ logMessage("📀  Backing up database...") }}
cd {{ $newReleaseDir }}
php8.3 artisan backup:run
@endtask

@task('migrateDatabase', ['on' => 'remote'])
{{ logMessage("🙈  Migrating database...") }}
cd {{ $newReleaseDir }};
php8.3 artisan migrate --force;
@endtask

@task('blessNewRelease', ['on' => 'remote'])
{{ logMessage("🙏  Blessing new release...") }}
ln -nfs {{ $newReleaseDir }} {{ $currentDir }};
cd {{ $newReleaseDir }}
php8.3 artisan config:clear
php8.3 artisan cache:clear
php8.3 artisan config:cache

sudo service php8.3-fpm restart
sudo supervisorctl restart all
@endtask

@task('cleanOldReleases', ['on' => 'remote'])
{{ logMessage("🚾  Cleaning up old releases...") }}
# Delete all but the 5 most recent.
cd {{ $releasesDir }}
ls -dt {{ $releasesDir }}/* | tail -n +6 | xargs -d "\n" sudo chown -R forge .;
ls -dt {{ $releasesDir }}/* | tail -n +6 | xargs -d "\n" rm -rf;
@endtask

@task('finishDeploy', ['on' => 'local'])
{{ logMessage("🚀  Application deployed!") }}
@endtask

@task('pullChanges',['on' => 'remote'])
{{ logMessage("💻  Deploying code changes...") }}
cd {{ $currentDir }}

eval `ssh-agent -s`
ssh-add -D
ssh-add ~/.ssh/id_rsa_rfc

git pull origin main

ssh-add -D
@endtask

@task('finishCodeDeploy',['on' => 'remote'])
cd {{ $currentDir }}

php8.3 artisan storage:link
php8.3 artisan config:clear
php8.3 artisan cache:clear
php8.3 artisan config:cache
sudo supervisorctl restart all
sudo service php8.3-fpm restart
@endtask
