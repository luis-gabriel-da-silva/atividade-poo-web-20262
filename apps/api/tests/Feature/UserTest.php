<?php

test('user', function () {
    $this->assertDatabaseCount('users', 0);

    //chamada principal

    $this->assertDatabaseHas('users');
});
