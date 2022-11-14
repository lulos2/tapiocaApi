      <?php

          class BaseController {

              protected $view;

              function __construct() {
                  $this->view = new ApiView();
              }

              public function getBody() {
                  $body = file_get_contents('php://input');
                  return json_decode($body);
              }
          }