<?php

namespace App\Entity;

class Package
{
    private string $name;
    private string $version;
    private bool $hasUpdate = false;
    private bool $isInstalled = true;
    private string $updateVersion;
    private string $updateUrl;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->version = $data['version'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function hasUpdate(): bool
    {
        return $this->hasUpdate;
    }

    public function setHasUpdate(bool $hasUpdate): self
    {
        $this->hasUpdate = $hasUpdate;

        return $this;
    }

    public function setIsInstalled(bool $isInstalled): self
    {
        $this->isInstalled = $isInstalled;

        return $this;
    }

    public function isInstalled(): bool
    {
        return $this->isInstalled;
    }
    
    public function setUpdateVersion(string $version): self
    {
        $this->updateVersion = $version;

        return $this;
    }

    public function getUpdateVersion(): string
    {
        return $this->updateVersion ?? '';
    }

    public function setUpdateUrl(string $url): self
    {
        $this->updateUrl = $url;

        return $this;
    }

    public function getUpdateUrl(): string
    {
        return $this->updateUrl ?? '';
    }

    public function startsWith(string $prefix): bool
    {
        return str_starts_with($this->getName(), $prefix);
    }
}
