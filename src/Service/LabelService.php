<?php

namespace App\Service;

use Symfony\Contracts\Translation\TranslatorInterface;


class LabelService{


    private $translator;

    public function __construct(TranslatorInterface $translator){
        $this->translator = $translator;
    }

    public function getDefaultLabels(): array{

        $labels = [
            'submit' => $this->translator->trans('submit')
        ];

        return $labels;
    }

    public function getPersonLabels() :array{
        $labels = [
            'son_of' => $this->translator->trans('Son of'),
            'and_of' => $this->translator->trans('and of'),
            'name' => $this->translator->trans('Name'),
            'lastnames' => $this->translator->trans('Lastnames')
        ];
        return array_merge($labels,$this->getDefaultLabels());
    }

}