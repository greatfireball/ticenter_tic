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

my $input = qx(xclip -o);

my @lines = split(/\r?\n/, $input);

foreach my $line (@lines)
{
    next unless ($line =~ /^\d+\s+(\d+):(\d+)\s+(\S+)\s+[*\s]*([\d.]+)\s+([\d.]+)\s+([.\d]+)\s*$/);

    my ($gala, $planet, $name, $extr, $rang, $point) = ($1, $2, $3, $4, $5, $6);

    $form{txtAccName} = $name;
    $form{txtAccGalaxie} = $gala;
    $form{txtAccPlanet} = $planet;
    $form{txtAccPasswort} = $name;

    use Data::Dumper;
    print Dumper(\%form);

#    my $response;next;
    my $response = $ua->post('http://gntic.foersterfrank.de/main.php?auto&modul=userman', \%form);
 
    if ($response->is_success) {
	#print $response->decoded_content;  # or whatever
	print "Angelegt: $name ($gala:$planet)\n";
    }
    else {
	die $response->status_line;
    }
}
