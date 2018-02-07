<?php

return [
    'presentation-maria' => [
        'id' => 1,
        'user_id' => 1, // user-maria
        'title' => 'Some Title',
        'description' => 'Some Description',
        'description_pure' => 'Some Description',
        'is_public' => 1,
        'created_at' => '1517834543',  //2018-02-05
        'updated_at' => '1517834543',  //2018-02-05
        'public_url' => 'some_title',
        'rating' => 0,
        'category_id' => 1, // Common
    ],
    'presentation-maria-2' => [
        'id' => 2,
        'user_id' => 1, // user-maria
        'title' => 'Some Another Title',
        'description' => 'Some Another Description',
        'description_pure' => 'Some Another Description',
        'is_public' => 0,
        'created_at' => '1517834545',  //2018-02-05
        'updated_at' => '1517834545',  //2018-02-05
        'public_url' => 'some_another_title',
        'rating' => 1,
        'category_id' => 2,  // Human
    ],
    'presentation-paul' => [
        'id' => 3,
        'user_id' => 2, // user-paul
        'title' => 'Paul presentation',
        'is_public' => 1,
        'created_at' => '1517834543',  //2018-02-05
        'updated_at' => '1517834543',  //2018-02-05
        'public_url' => 'paul_presentation',
        'rating' => 0,
        'category_id' => 3, // Animal
    ],
];
