<?php

namespace markhuot\CraftQL\Types;

use Craft;
use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\Type;
use markhuot\CraftQL\FieldBehaviors\RelatedCategoriesField;
use markhuot\CraftQL\Request;
use markhuot\CraftQL\Builders\Schema;
use markhuot\CraftQL\FieldBehaviors\RelatedEntriesField;

class EntryEdge extends Schema {

    function boot() {
        $this->addStringField('cursor');

        $this->addField('node')
            ->type(EntryInterface::class)
            ->resolve(function ($root) {
                return $root['node'];
            });

        $this->use(new RelatedEntriesField);
        $this->use(new RelatedCategoriesField);

        $this->addField('drafts')
            ->type(EntryDraftConnection::class)
            ->resolve(function ($root, $args, $context, $info) {
                $drafts = Craft::$app->entryRevisions->getDraftsByEntryId($root['node']->id);
                return [
                    'totalCount' => count($drafts),
                    'pageInfo' => [
                        'currentPage' => 1,
                        'totalPages' => 1,
                        'first' => 1,
                        'last' => 1,
                    ],
                    'edges' => $drafts,
                ];
            });
    }

}