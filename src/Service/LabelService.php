<?php

namespace App\Service;

use App\Entity\Person;
use Symfony\Contracts\Translation\TranslatorInterface;


class LabelService{


    private $translator;

    public function __construct(TranslatorInterface $translator){
        $this->translator = $translator;
    }

    public function getDefaultLabels(): array{

        $labels = [
            'next' => $this->translator->trans('Next'),
            'previous' => $this->translator->trans('Previous'),
            'add' => $this->translator->trans('Add'),
            'remove' => $this->translator->trans('Remove'),
            'saved_successfully' => $this->translator->trans('Saved successfully'),
            'and' => $this->translator->trans('and')
        ];

        return $labels;
    }

    public function getPersonLabels() :array{
        $labels = [
            'son_of' => $this->translator->trans('Son of'),
            'and_of' => $this->translator->trans('and of'),
            'treatment' => $this->translator->trans('Treatment'),
            'name' => $this->translator->trans('Name'),
            'lastnames' => $this->translator->trans('Lastnames'),
            'birthdate' => $this->translator->trans('Birthdate'),
            'birthplace' => $this->translator->trans('Birthplace'),
            'deathdate' => $this->translator->trans('Deceased date'),
            'deathplace' => $this->translator->trans('Deseace place'),
            'children' => $this->translator->trans('Children'),
            'child' => $this->translator->trans('Children'),
            'save_gallery' => $this->translator->trans('Save gallery'),
            'add_pictures' => $this->translator->trans('Add pictures'),
            'create_gallery' => $this->translator->trans('Create gallery'),
            'delete_gallery' => $this->translator->trans('Delete gallery'),
            'delete_gallery_warning' => $this->translator->trans("This action can't be undone. Are you sure you want to proceed?"),
            'removed_successfully' => $this->translator->trans("Removed successfully"),
            'gallery_title' => $this->translator->trans("Gallery title"),
            'description' => $this->translator->trans("Biography"),
            'father_of' => $this->translator->trans("Father of"),
            'mother_of' => $this->translator->trans("Mother of"),
            'parent_to' => $this->translator->trans("Parent to"),
            'show_family_tree' => $this->translator->trans('Show family tree'),
            'default_description' => $this->translator->trans('<strong>NAME_PLACEHOLDER LASTNAME_PLACEHOLDER</strong> (BIRTHDATE_PLACEHOLDER
            in BIRTHPLACE_PLACEHOLDER - DEATHDATE_PLACEHOLDER in DEATHPLACE_PLACEHOLDER). PARENTS_PLACEHOLDER. CHILDREN_PLACEHOLDER'),
            'stepTitles' => [
                $this->translator->trans('Basic information'),
                $this->translator->trans('Family'),
                $this->translator->trans('Extra information'),
                $this->translator->trans('Galleries')
            ],
            'treatments' => [
                [
                    'value' => Person::MASCULINE_TREATMENT,
                    'text' => $this->translator->trans('Masculine'),
                ],
                [
                    'value' => Person::FEMENINE_TREATMENT,
                    'text' => $this->translator->trans('Femenine'),
                ],
                [
                    'value' => Person::NEUTRAL_TREATMENT,
                    'text' => $this->translator->trans('Neutral'),
                ]
            ]
        ];
        return array_merge($labels,$this->getDefaultLabels());
    }

}