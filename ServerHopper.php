<?php
// EDIT SERVER LIST HERE
// You need a comma after every entry EXCEPT the last one
// Follow the examples
// The name and order listed here are how it's displayed on the servers
// The order here decides server ID for Advertisement and ChatCmds in the lua addon
// The first server is id 0, the second is id 1, third is id 2, and so on

header('Content-type: application/json');

$servers = array(
    "Trouble In Terrorist Town" => "74.91.116.42:27015",
    "Gun Game" => "162.248.95.65:27015"

);

// DO NOT EDIT BELOW THIS LINE

ini_set('max_execution_time', 10);
function source_query($ip){
    $cut = explode(":", $ip);
    $HL2_address = $cut[0];
    $HL2_port = $cut[1];
 
    $HL2_command = "\377\377\377\377TSource Engine Query\0";
    $HL2_socket = fsockopen("udp://".$HL2_address, $HL2_port, $errno, $errstr,3);
    stream_set_timeout($HL2_socket, 2);
    fwrite($HL2_socket, $HL2_command); 
    $JunkHead = fread($HL2_socket,4);
    $CheckStatus = socket_get_status($HL2_socket);
    if($CheckStatus["unread_bytes"] == 0)return 0;
    $do = 1;
    while($do){
        $str = fread($HL2_socket,1);
        $HL2_stats.= $str;
        $status = socket_get_status($HL2_socket);
        if($status["unread_bytes"] == 0){
            $do = 0;
        }
    }
    fclose($HL2_socket);
    $x = 0;
    while ($x <= strlen($HL2_stats)){
        $x++;
        $result.= substr($HL2_stats, $x, 1);    
    }
    // ord ( string $string );
    $result = str_split($result);
    $info['network'] = ord($result[0]);$char = 1;
    while(ord($result[$char]) != "%00"){$info['name'] .= $result[$char];$char++;}$char++;
    while(ord($result[$char]) != "%00"){$info['map'] .= $result[$char];$char++;}$char++;
    while(ord($result[$char]) != "%00"){$info['dir'] .= $result[$char];$char++;}$char++;
    while(ord($result[$char]) != "%00"){$info['gamemode'] .= $result[$char];$char++;}$char++;
    $info['appid'] = ord($result[$char].$result[($char+1)]);$char += 2;
    $info['players'] = ord($result[$char]);$char++;
    $info['maxplayers'] = ord($result[$char]);$char++;
    $info['bots'] = ord($result[$char]);$char++;
    $info['dedicated'] = ord($result[$char]);$char++;
    $info['os'] = chr(ord($result[$char]));$char++;
    $info['password'] = ord($result[$char]);$char++;
    $info['secure'] = ord($result[$char]);$char++;
    while(ord($result[$char]) != "%00"){$info['version'] .= $result[$char];$char++;}
    
    return $info;
}
$completeServers = array();
$id = 0;
foreach($servers as $name => $ip) {
    $q = source_query($ip);
    $serverTable = array(
        "id" => $id,
        "ip" => $ip,
        "players" => $q['players'],
        "maxplayers" => $q['maxplayers'],
        "map" => $q['map'],
        "gamemode" => $q['gamemode']
    );
    $completeServers[$name] = $serverTable;
    $id = $id + 1;
}
echo(json_encode($completeServers));
?>