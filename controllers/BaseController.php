      <?php

          class BaseController {

              public function getBody(){
                  $body = file_get_contents('php://input');
                  return json_decode($body);
              }
          }