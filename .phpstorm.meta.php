<?php

namespace PHPSTORM_META {
    override(
        \App\Controller\AbstractApiController::buildObject(),
        map([
            '' => '@'
        ])
    );
    override(
        \App\Tests\Service\ContainerHelperTestTrait::getRealService(),
        map([
            '' => '@'
        ])
    );
}
