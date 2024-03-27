<?php

namespace Core\Forge\Helpers\IPAddress;

class IPHelper {

    public static function checkReservedIPv4(string $IPAddress) : bool {
        $ReservedScope = array( // not an exhaustive list
            '167772160'  => 184549375,  /*    10.0.0.0 -  10.255.255.255 */
            '3232235520' => 3232301055, /* 192.168.0.0 - 192.168.255.255 */
            '2130706432' => 2147483647, /*   127.0.0.0 - 127.255.255.255 */
            '2851995648' => 2852061183, /* 169.254.0.0 - 169.254.255.255 */
            '2886729728' => 2887778303, /*  172.16.0.0 -  172.31.255.255 */
            '3758096384' => 4026531839, /*   224.0.0.0 - 239.255.255.255 */
        );

        $LongIP= sprintf('%u', ip2long($IPAddress));

        foreach ($ReservedScope as $ip_start => $ip_end)
        {
            if (($LongIP >= $ip_start) && ($LongIP <= $ip_end))
            {
                return true;
            }
        }
        return false;
    }

    public static function checkReservedIPv6(string $IPAddress) : bool {
        $ReservedScope = array(
          "::1"
        );

        if (in_array($IPAddress, $ReservedScope, true)) {
            return true;
        }

        return false;
    }
}