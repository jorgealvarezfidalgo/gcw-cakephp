<?php
$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('posts'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$this->Breadcrumbs->add('Editar post' . ' ' . $entity->title, [
    'controller' => $this->request->getParam('controller'),
    'action' => 'edit',
    $entity->id
]);
$header = [
    'title' => 'Editar post',
    'breadcrumbs' => true
];
?>

<?= $this->element("header", $header); ?>

<div class="content">
<?= $this->Form->create(
    $entity,
    [
        'class' => 'admin-form',
        'type' => 'file'
    ]
); ?>
    <div class="primary">
            <div class="form-block">
                <h3>Datos generales del post</h3>
                <?= $this->Form->control(
                    'title',
                    [
                        'label' => 'Título',
                        'type' => 'text',
                        'templateVars' => [
                            'max' =>  100
                        ]
                    ]
                ); ?>
                <?= $this->Form->control(
                    'excerpt',
                    [
                        'label' => 'Extracto de la noticia',
                        'rows' => 5,
                        'templateVars' => [
                            'max' =>  200
                        ]
                    ]
                ); ?>
                <?= $this->Form->control(
                    'category_id',
                    [
                        'label' => 'Categoría',
                        'options' => $categories,
                        'escape' => false
                    ]
                ); ?>
                <?= $this->Form->control(
                    'tags._ids',
                    [
                        'label' => 'Tags',
                        'options' => $tags,
                        'escape' => false
                    ]
                ); ?>
            </div><!-- .form-block -->
        <div class="form-block content-block">
            <h3>Contenido</h3>
            <?= $this->Form->control(
                'content',
                [
                    'label' => false,
                    'class' => 'texteditor'
                ]
            ); ?>
        </div><!-- .form-block -->
    </div><!-- .primary -->
    <?= $this->element("form/save-block"); ?>
<?= $this->Form->end() ?>
</div><!-- .content -->
