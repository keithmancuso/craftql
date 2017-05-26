<?php

namespace Craft;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CraftQL_FieldTextService extends BaseApplicationComponent {

  function getDefinition($field) {
    return [
      $field->handle => [
        'type' => Type::string(),
        'args' => [
          ['name' => 'page', 'type' => Type::int()],
        ],
        'resolve' => function ($root, $args) use ($field) {
          if (!empty($args['page'])) {
            return $root->{$field->handle}->getPage($args['page']);
          }

          return $root->{$field->handle};
        }
      ],
    ];
  }

}
