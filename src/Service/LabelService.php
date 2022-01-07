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
            'save' => $this->translator->trans('Save'),
            'save_and_continue' => $this->translator->trans('Save and continue'),
            'add' => $this->translator->trans('Add'),
            'remove' => $this->translator->trans('Remove'),
            'saved_successfully' => $this->translator->trans('Saved successfully'),
            'and' => $this->translator->trans('and'),
            'welcome' => $this->translator->trans('Welcome to Memora Plate'),
            'upload_image' => $this->translator->trans('Upload image'),
        ];

        return $labels;
    }

    public function getEcommerceLabels(): array{
        $labels = [
            'quantity' => $this->translator->trans('Quantity'),
            'checkout' => $this->translator->trans('Checkout'),
            'maintenance_explanation' => $this->translator->trans('For maintenance purposes we do need a symbolic fee subscription.'),
            'extra_products_explanation' => $this->translator->trans('You can also order a memorial plate here.'),
        ];
        return $labels;
    }

    public function getPersonLabels() :array{
        $labels = [
            'subscription_active_until' => $this->translator->trans('Subscription active until'),
            'subscription_inactive' => $this->translator->trans("There's no active subscription"),
            'data_will_be_deleted' => $this->translator->trans("Data will be deleted on "),
            'upload_picture' => $this->translator->trans('Upload picture'),
            'parents' => $this->translator->trans('Parents'),
            'no_persons' => $this->translator->trans('You haven\'t created any persons yet.'),
            'create_person' => $this->translator->trans('Create person'),
            'edit_person' => $this->translator->trans('Edit person'),
            'view_person' => $this->translator->trans('View person'),
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
            'child' => $this->translator->trans('Child'),
            'save_gallery' => $this->translator->trans('Save gallery'),
            'edit_gallery' => $this->translator->trans('Edit gallery'),
            'create_gallery' => $this->translator->trans('Create gallery'),
            'delete_gallery' => $this->translator->trans('Delete gallery'),
            'delete_gallery_warning' => $this->translator->trans("This action can't be undone. Are you sure you want to proceed?"),
            'removed_successfully' => $this->translator->trans("Removed successfully"),
            'gallery_title' => $this->translator->trans("Gallery title"),
            'gallery_add_pictures' => $this->translator->trans('Add pictures to gallery'),
            'description' => $this->translator->trans("Biography"),
            'add_favourite' => $this->translator->trans("Add favourite"),
            'favorite_type' => $this->translator->trans("Favourite type"),
            'favorite_type_placeholder' => $this->translator->trans('actors, movies, books...'),
            'favorites' => $this->translator->trans("Favourites"),
            'nicknames' => $this->translator->trans("Nicknames"),
            'nicknames_placeholder' => $this->translator->trans('Add nichnames separated by commas'),
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