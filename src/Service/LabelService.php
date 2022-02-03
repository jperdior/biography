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
            'welcome' => $this->translator->trans('Welcome to Recordari'),
            'upload_image' => $this->translator->trans('Upload image'),
            'login' => $this->translator->trans('Login'),
            'logout' => $this->translator->trans('Logout'),
            'register' => $this->translator->trans('Register'),
            'no_account' => $this->translator->trans('No account? Click here to register'),
            'email' => $this->translator->trans('Email'),
            'password' => $this->translator->trans('Password'),
            'fullname' => $this->translator->trans('Full name'),
            'delete' => $this->translator->trans('Delete')
        ];

        return $labels;
    }

    public function getProductLabels(): array{
        $labels = [
            'choose_font' => $this->translator->trans('Choose typography'),
            'choose_material' => $this->translator->trans('Choose material'),
            'choose_size' => $this->translator->trans('Choose size'),
            'quantity' => $this->translator->trans('Quantity'),
            'checkout' => $this->translator->trans('Checkout'),
            'maintenance_explanation' => $this->translator->trans('For maintenance purposes we do need a symbolic fee subscription.'),
            'extra_products_explanation' => $this->translator->trans('You can also order a memorial plate here.'),
            'customize_memorial_plate' => $this->translator->trans('Customize your commemorative plate here'),
            'material_options' => [
                [
                    'value' => 'steel',
                    'text' => $this->translator->trans('Steel'),
                ],
                [
                    'value' => 'brass',
                    'text' => $this->translator->trans('Brass'),
                ],
                [
                    'value' => 'aluminum',
                    'text' => $this->translator->trans('Aluminum'),
                ],
                [
                    'value' => 'methacrylate',
                    'text' => $this->translator->trans('Methacrylate'),
                ],
                [
                    'value' => 'acrilic',
                    'text' => $this->translator->trans('Acrilic'),
                ],
            ]
        ];
        return $labels;
    }

    public function getNoteLabels(): array{
        $labels = [
            'admin_table_fields' => [
                [
                    'key' => 'fullname',
                    'label' => $this->translator->trans('Author')
                ],
                [
                    'key' => 'body',
                    'label' => $this->translator->trans('Message')
                ],
                [
                    'key' => 'approved',
                    'label' => $this->translator->trans('Approved')
                ],
                [
                    'key' => 'actions',
                    'label' => $this->translator->trans('Actions')
                ],
            ],
            'approve' => $this->translator->trans('Approve'),
            'disapprove' => $this->translator->trans('Disapprove'),
            'delete_confirm' => $this->translator->trans('Are you sure you want to delete this note? This action can\'t be undone.')
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
            'edit_memorial' => $this->translator->trans('Edit memorial'),
            'view_memorial' => $this->translator->trans('View memorial'),
            'son_of' => $this->translator->trans('Son of'),
            'and_of' => $this->translator->trans('and of'),
            'treatment' => $this->translator->trans('Treatment'),
            'name' => $this->translator->trans('Name'),
            'lastnames' => $this->translator->trans('Lastnames'),
            'birthdate' => $this->translator->trans('Birthdate'),
            'birthplace' => $this->translator->trans('Birthplace'),
            'deathdate' => $this->translator->trans('Deceased date'),
            'deathplace' => $this->translator->trans('Deseace place'),
            'privacy_configuration' => $this->translator->trans('Privacy configuration'),
            'private_memorial' => $this->translator->trans('Private memorial'),
            'allow_notes_or_galleries' => $this->translator->trans('Allow memorial visitors to post notes or galleries'),
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
                $this->translator->trans('Galleries'),
                $this->translator->trans('Finish')
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
                ],
            'eventTypes' => [
                [
                    'value' => 'birthdate',
                    'text' => $this->translator->trans('Birthdate')
                ],
                [
                    'value' => 'deathdate',
                    'text' => $this->translator->trans('Decease date')
                ]
                ],
                'google_calendar' => $this->translator->trans('Google calendar'),
                'add_reminder' => $this->translator->trans('Add reminder'),
                'reminder_type' => $this->translator->trans('Reminder type'),
                'recordari_meaning' => $this->translator->trans('La palabra "<b>recordar</b>" viene del latín "<i>recordari</i>
                  ", formado por <i>re</i> (de nuevo) y <i>cordis</i> (corazón).
                  Recordar quiere decir mucho más que tener a alguien presente
                  en la memoria. Significa "volver a pasar por el corazón".'),
                  'know_more' => $this->translator->trans('Know more')
        ];
        return $labels;
    }

}