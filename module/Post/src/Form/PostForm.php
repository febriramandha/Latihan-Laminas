<?php

namespace Post\Form;

use Laminas\Form\Form;

class PostForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('post');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'judul',
            'type' => 'text',
            'options' => [
                'label' => 'Judul',
            ],
        ]);

        $this->add([
            'name' => 'deskripsi',
            'type' => 'textarea',
            'options' => [
                'label' => 'Deskripsi',
            ],
        ]);

        $this->add([
            'name' => 'kategori',
            'type' => 'text',
            'options' => [
                'label' => 'Kategori',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
