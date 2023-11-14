<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ErrorController extends AbstractController
{
    public function show(FlattenException $flattenException, Environment $environment): Response
    {
        $view = "bundles/TwigBundle/Exception/error{$flattenException->getStatusCode()}.html.twig";

        if (!$environment->getLoader()->exists($view)) {
            $view = "bundles/TwigBundle/Exception/error.html.twig";
        }
        return $this->render($view);
    }
}
