<?php


$ldapServerURI = getenv('LDAPURI');
$userdn = getenv('LDAPDN');
$userpw = getenv('LDAPPW');
$usercn = getenv('USERCN');
$basedn = getenv('BASEDN');

ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 0);  // level 7 for extensive trace
$connect = ldap_connect($ldapServerURI);
if ($connect) {
    print "Connection to $ldapServerURI OK\n";
} else {
    fwrite(STDERR, "cannot connect to $ldapServerURI.\n");
    exit(1);
}

ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($connect, LDAP_OPT_REFERRALS, 0 );
if (ldap_bind($connect, $userdn, $userpw)) {
    print "Authentication as user $userdn OK\n";
} else {
    fwrite(STDERR, "cannot bind as user $userdn.\n");
    exit(2);
}

$search = ldap_search($connect, $basedn, '(objectclass=*)');
if (ldap_errno > 0) {
    print("ldap search failed with LDAP error " . ldap_error($connect));
    exit(3);
}

$entries = ldap_get_entries($connect, $search);
if (!ldap_errno) {
    fwrite(STDERR, "ldap_get_entries failed" . ldap_error($connect) . "\n");
    exit(4);
} elseif (sizeof($entries) > 0) {
    print("Search returned " . sizeof($entries) . " entries.\n");
} else {
    print("No entries found with basedn $basedn and (objectclass=*)\n");
    exit(5);
}
?>