<?php

namespace App\Controllers;


use App\Enums\Privilege;
use ErrorException;
use ReflectionException;

class VotesController extends AbstractController
{
    public static int $authentication = Privilege::Guide->value;

    /**
     * #[GET('/votes')]
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");
        $this->language->load("votes.common");
        $this->language->load("votes.index");

        $this->authentication("votes.index", [
        ]);
    }



    /**
     * GET('/votes/add')
     * @throws ErrorException|ReflectionException
     */
    public function add(): void
    {
        $this->language->load("template.common");


        $this->authentication("votes.add", [
        ]);
    }

    /**
     * Edit major
     * @throws ErrorException
     * @throws ReflectionException
     */
    public function edit(): void
    {

        $this->language->load("template.common");

        $this->authentication("votes.edit", [
        ]);
    }


}