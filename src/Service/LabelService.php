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
            'save_and_continue' => $this->translator->trans('Save and continue'),
            'save' => $this->translator->trans('Save')
        ];

        return $labels;
    }

    public function getPersonLabels() :array{
        $labels = [
            'son_of' => $this->translator->trans('Son of'),
            'and_of' => $this->translator->trans('and of'),
            'name' => $this->translator->trans('Name'),
            'lastnames' => $this->translator->trans('Lastnames'),
            'stepTitles' => [
                $this->translator->trans('Basic information'),
                $this->translator->trans('Family'),
                $this->translator->trans('Extra information'),
                $this->translator->trans('Galleries')
            ]
        ];
        return array_merge($labels,$this->getDefaultLabels());
    }

}