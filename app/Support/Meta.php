<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

final class Meta
{
    public function __construct(
        public string $title,
        public string $description,
        public string $image,
    ) {
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function image(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function render(): HtmlString
    {
        $meta = <<<HTML
        {$this->renderTitle()}
        {$this->renderDescription()}
        {$this->renderImage()}
        {$this->renderMisc()}
        HTML;

        return new HtmlString($meta);
    }

    private function renderTitle(): string
    {
        return <<<HTML
        <meta name="title" content="$this->title">
        <meta name="twitter:title" content="$this->title">
        <meta property="og:title" content="$this->title">
        <meta itemprop="name" content="$this->title">
        HTML;
    }

    private function renderDescription(): string
    {
        return <<<HTML
        <meta name="description" content="$this->description">
        <meta name="twitter:description" content="$this->description">
        <meta property="og:description" content="$this->description">
        <meta itemprop="description" content="$this->description">
        HTML;
    }

    private function renderImage(): string
    {
        return <<<HTML
        <meta property="og:image" content="$this->image"/>
        <meta property="twitter:image" content="$this->image"/>
        <meta name="image" content="$this->image"/>
        HTML;
    }

    private function renderMisc(): string
    {
        return <<<'HTML'
        <meta name="viewport" content="initial-scale=1, viewport-fit=cover" />
        <meta charset="UTF-8">

        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:creator" content="@brendt_gd"/>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        HTML;
    }
}
