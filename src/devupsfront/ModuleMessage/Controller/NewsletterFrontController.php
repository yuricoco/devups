<?php


namespace devupscms\ModuleMessage\Controller;


class NewsletterFrontController extends \NewsletterController
{
    public function createAction($newsletter_form = null)
    {
        $newsletter = new \Newsletter();
        $newsletter->setEmail(\Request::post("email"));
        $newsletter->setCreationdate(new \DateTime());
        $newsletter->__insert();

        \Response::set("newsletter", $newsletter);
        return \Response::$data;
    }
}