<?php

namespace TheNavigators\SiteCheckNotify;

interface SiteCheckInterface
{
    public function check(string $url);
}