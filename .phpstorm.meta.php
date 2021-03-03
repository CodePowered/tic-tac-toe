<?php

namespace PHPSTORM_META {
    override(
        \App\Controller\AbstractApiController::buildObject(),
        map([
            '' => '@'
        ])
    );
    override(
        \App\Tests\Repository\AbstractRepositoryTest::getRealService(),
        map([
            '' => '@'
        ])
    );
}
