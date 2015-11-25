#!/usr/bin/env perl

use strict;
use warnings;

require LWP::UserAgent;
 
my $ua = LWP::UserAgent->new;
$ua->timeout(10);
$ua->env_proxy;

my %form = (
    action => "accounterstellen",
    txtAccName => "test",
    txtAccGalaxie => "32",
    txtAccPlanet => "2",
    txtAccPasswort => "test",
    lstAllianz => 1,
    lstRang => 0,
    username => $ARGV[0],
    userpass => $ARGV[1]
    );

my $response = $ua->post('http://gntic.foersterfrank.de/main.php?auto&modul=userman', \%form);
 
if ($response->is_success) {
    print $response->decoded_content;  # or whatever
}
else {
    die $response->status_line;
}
