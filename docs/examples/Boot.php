<?php

use Rhubarb\Leaf\ModelSelectionControls\Examples\ContactExample;

include_once __DIR__.'/ContactExample.php';

$faker = \Faker\Factory::create();
$faker->seed(123);

for($x = 0; $x < 500; $x++) {
    $contact = new ContactExample();
    $contact->firstname = $faker->firstName;
    $contact->surname = $faker->lastName;
    $contact->age = $faker->numberBetween(15, 74);
    $contact->save();
}