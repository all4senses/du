<?php if (!$page): ?>
  <article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <!-- <div class="inside"> -->
<?php else: ?>
  <div class="main-content"> 
<?php endif; ?>
 
          

      <?php if (!$page): ?>
        <header>
      <?php endif; ?>

          <?php if ($page): ?>
          <h1 
          <?php else: ?>
          <h2 
          <?php endif; ?>
              
            <?php print ' ' . /*$title_attributes*/ /*preg_replace('/datatype=".*"/', '', $title_attributes);*/ preg_replace('/datatype=""/', '', $title_attributes); if (!$node->status) {echo ' class="not-published"';} ?>>
            
            <?php if (!isset($node->title_no_link) && !$page): ?>
              <a href="<?php print $node_url; ?>">
                <?php print $title; ?>
              </a>
            <?php else: ?>
              <?php print $title; ?>
            <?php endif; ?>

          <?php if ($page): ?>
          </h1>
          <?php else: ?>
          </h2>
          <?php endif; ?> 


          <span class="submitted">
            <?php 
            
              $created_str = date('F d, Y \a\t g:ia', $node->created);
              $created_rdf = preg_replace('|(.*)content=\"(.*)\"\s(.*)|', '$2', $date); //date('Y-m-d\TH:i:s', $node->created); 
              
              //$author = user_load($node->uid);
              //$author_name = $author->realname;
              
              if ($page || $node->type == 'article') {
                $authorExtendedData = du_misc_loadUserExtendedData($node->uid);
                $author_name = $authorExtendedData->realname;
              }
            
              if ($page) {
                
               
                if ($node->uid) {
                  
                  global $language;
                  
                  $author_url = url('user/' . $node->uid);
                  $author_title = t('!author\'s profile', array('!author' => $author_name));

                  $submitted = '<span property="dc:date dc:created" content="' . $created_rdf . '" datatype="xsd:dateTime" rel="sioc:has_creator">' .
                                  t('By') . ':' .
                                  //'<a href="' . $author_url . '" title="View user profile." class="username" lang="' . $language->language . '" xml:lang="' . $language->language . '" about="' . $author_url . '" typeof="sioc:UserAccount" property="foaf:name">' .
                                  '<a href="' . $author_url . '" title="' . $author_title . '" class="username" lang="' . $language->language . '" xml:lang="' . $language->language . '" about="' . $author_url . '" typeof="sioc:UserAccount" property="foaf:name">' .
                                    $author_name .
                                  '</a>' .
                                  ($node->type == 'article' ? '' : '<span class="delim">|</span>' . $created_str) .
                               '</span>';
                  
                 
                }
                else {
                  $submitted = '<span property="dc:date dc:created" content="' . $created_rdf . '" datatype="xsd:dateTime" rel="sioc:has_creator">' .
                                  t('By') . ':' .
                                  '<span class="username">' .
                                    t('Guest') .
                                  '</span>' .
                                  ($node->type == 'article' ? '' : '<span class="delim">|</span>' . $created_str) .
                               '</span>';
                  
                }
                
                echo $submitted;
              }
              else {
                if ($node->type == 'article') {
                  echo t('By') , ': ' , $author_name;
                }
                else {
                  echo $created_str;
                }
              }
              
            ?>
          </span>


      <?php if (!$page): ?>
        </header>
      <?php endif; ?>



      <div class="content <?php echo ($page ? 'page' : 'teaser'); ?>"<?php print $content_attributes; ?>>
        <?php
          // Hide comments, tags, and links now so that we can render them later.
          hide($content['comments']);
          hide($content['links']);
          hide($content['field_tags']);
          
          
          if (!$page) {
            
            // TODO: Temporary check. Should be removed after all articles resave.
            if (isset($node->field_a_teaser['und'][0]['value']) && $node->field_a_teaser['und'][0]['value']) {
              echo $node->field_a_teaser['und'][0]['value'];
            }
            else {
              $teaser_data = du_misc_getArticleTeaserData('all', $content['body'][0]['#markup'], $node->nid);
              echo $teaser_data['teaser'];
            }
            
            hide($content['body']);
          }
          
          
          $keyword_metatag_name = 'keywords';
          
          if (isset($content['metatags']['keywords'])) {
            hide($content['metatags']['keywords']);
          }
          
          if (isset($content['metatags']['keywords']['#attached']['drupal_add_html_head'][0][0]['#value']) && $content['metatags']['keywords']['#attached']['drupal_add_html_head'][0][0]['#value']) {
            du_misc_addMetatag($keyword_metatag_name, $content['metatags']['keywords']['#attached']['drupal_add_html_head'][0][0]['#value']);
          }
          elseif (@$content['field_tags']) {
            du_misc_pushTagsToMetatags($keyword_metatag_name, $content['field_tags']);
          }
          
          echo render($content);
        ?>
      </div>



      <?php if ($page): ?>
    
                  <footer>

                    <div class="share">

                      <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . url('node/' . $node->nid); ?>
                      
                      <div class="main">
                          <?php echo dmm_social_getSocialiteButtons($url, $title); ?> 
                      </div> <!-- main share buttons -->

                      <div class="others">
                        <!-- ADDTHIS BUTTON BEGIN -->
                        <script type="text/javascript">
                        var addthis_config = {
                            //pubid: "all4senses"
                        }
                        var addthis_share =
                        {
                          // ... members go here
                          url: "<?php echo $url?>"
                        }
                        </script>

                        <div class="addthis_toolbox addthis_default_style" addthis:url="<?php echo $url?>">
                          <a href="http://addthis.com/bookmark.php?v=250&amp;pub=all4senses"></a>
                          <a class="addthis_button_compact"></a>
                        </div>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pub=all4senses"></script>
                        <!-- ADDTHIS BUTTON END -->

                      </div>
                      
                    </div> <!-- all share buttons -->
                    

                    <?php 
                      if (isset($node->field_tags['und'])) {
                        $tags = NULL;
                        foreach ($node->field_tags['und'] as $key => $value) {
                          $tags .= ($tags ? '<div class="delim">|</div>' : '') . l(t($content['field_tags'][$key]['#title']), 'taxonomy/term/' . $value['tid']);
                        }
                        if ($tags) {
                          echo '<div class="tags"><div class="title">' . t('TAGS:') . '</div>' . $tags . '<div class="bottom-clear"></div></div>';
                        }
                      }
                    ?>
                  </footer>
    
    
      <?php endif; ?>
    
      <div class="bottom-clear"></div>
 
  
  <?php 
      if (!$user->uid) {
        echo du_user_loginToComment();
      }

      print render($content['comments']);
  ?>
    

<?php if (!$page): ?>
  </article> <!-- /.node -->
<?php else: ?>  
  </div> <!-- main-content -->
<?php endif; ?>


