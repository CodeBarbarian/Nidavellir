<?php

namespace Core\Forge\System;




class System {
    /**
     * Current Version
     *  0.0.X = Alpha
     *  0.x.X = Beta
     *  X.X.X = Release
     */
    public static string $FrameworkVersion = "0.0.1";

    public static function getFrameworkVersion() : string {
        return static::$FrameworkVersion;
    }
}