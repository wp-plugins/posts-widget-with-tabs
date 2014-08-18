<?php

/**
 * Plugin Name: Posts widget with tabs
 * Description: Tabs widget for wordpress
 * Version: 1.0
 * Author: WEB4PRO_co
 * Author URI: http://web4pro.net
 */
class tabs_widget extends WP_Widget {

    function tabs_widget() {
        $widget_ops = array('classname' => 'tabs_widget', 'description' => 'Wordpress tabs widget');
        $this->WP_Widget('tabs_widget', 'Tabs widget', $widget_ops);
    }
// Widget settings form
    function form($instance) {
        $count_tabs = 3; // Count of tabs
        for ($i = 1; $i <= $count_tabs; $i++):
            $defaults = array('title_tab' . $i . '' => '', 'content_type_tab' . $i . '' => '', 'category_tab' . $i . '' => '', 'order_tab' . $i . '' => '',
                              'orderby_tab' . $i . '' => '', 'show_image_tab' . $i . '' => '', 'number_tab' . $i . '' => '');
            $instance = wp_parse_args((array) $instance, $defaults);
            // saves variables
            $title_tab[$i] = esc_attr($instance['title_tab' . $i ]);
            $content_type_tab[$i] = esc_attr($instance['content_type_tab' . $i ]);
            $category_tab[$i] = esc_attr($instance['category_tab' . $i ]);
            $order_tab[$i] = esc_attr($instance['order_tab' . $i ]);
            $orderby_tab[$i] = esc_attr($instance['orderby_tab' . $i ]);
            $image_tab1[$i] = esc_attr($instance['show_image_tab' . $i ]);
            $number_tab[$i] = esc_attr($instance['number_tab' . $i ]);
            ?>
            <h3><?php echo _e('Tab ' . $i ); ?></h3>
            <hr>
            <p>
                <label for="<?php echo $this->get_field_id('title_tab' . $i . ' :'); ?>"><?php _e('Tab ' . $i . ' Title:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title_tab' . $i ); ?>"
                       name="<?php echo $this->get_field_name('title_tab' . $i ); ?>" type="text"
                       value="<?php echo $title_tab[$i]; ?>"/>
            </p>
            <p>	
                <label for="<?php echo $this->get_field_id('content_type_tab' . $i ); ?>"><?php _e('Choose the Content Type to display :'); ?></label>
                <select name="<?php echo $this->get_field_name('content_type_tab' . $i ); ?>" id="<?php echo $this->get_field_id('content_type_tab' . $i ); ?>" class="widefat"/>
                <?php
                $post_types_tab = get_post_types(array('public' => true), 'names');
                foreach ($post_types_tab as $type) {
                    if ($type != 'attachment') {
                        echo '<option id="' . $type . '"'. selected($content_type_tab[$i], $type). '>' .$type .'</option>';
                    }
                }
                ?>
            </select>		
            </p>
            <p>	
                <label for="<?php echo $this->get_field_id('category_tab' . $i ); ?>"><?php _e('Choose the Category to display :'); ?></label>
                <select name="<?php echo $this->get_field_name('category_tab' . $i ); ?>" id="<?php echo $this->get_field_id('category_tab' . $i ); ?>" class="widefat"/>
                <?php
                $categories_tab = get_categories();
                foreach ($categories_tab as $option) {
                    echo '<option id="' . $option->term_id . '" value="' . $option->slug . '"'. selected($category_tab[$i], $option->slug). '>' .$option->name .'</option>';
                }
                ?>
            </select>		
            </p>
            <h4><?php _e('Choose the filter criteria :'); ?></h4>
            <p>       
                <label for="<?php echo $this->get_field_id('order_tab' . $i ); ?>"><?php _e('Order Posts by :'); ?></label>
                <select name="<?php echo $this->get_field_name('order_tab' . $i ); ?>" id="<?php echo $this->get_field_id('order_tab' . $i ); ?>" class="widefat"/>
            <option id="post_asc" <?php selected($order_tab[$i], 'ASC'); ?>><?php _e('ASC');?></option>
            <option id="post_desc" <?php selected($order_tab[$i], 'DESC'); ?>><?php _e('DESC');?></option>
            </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('orderby_tab' . $i ); ?>"><?php _e('Order Posts by fields :'); ?></label>
                <select name="<?php echo $this->get_field_name('orderby_tab' . $i ); ?>" id="<?php echo $this->get_field_id('orderby_tab' . $i ); ?>" class="widefat"/>
            <option id="post_title" <?php selected($orderby_tab[$i], 'title'); ?>><?php _e('title');?></option>
            <option id="post_author" <?php selected($orderby_tab[$i], 'author'); ?>><?php _e('author');?></option>
            <option id="post_name" <?php selected($orderby_tab[$i], 'name'); ?>><?php _e('name');?></option>
            <option id="post_date" <?php selected($orderby_tab[$i], 'date'); ?>><?php _e('date');?></option>
            <option id="post_modified" <?php selected($orderby_tab[$i], 'modified'); ?>><?php _e('modified');?></option>
            <option id="post_rand" <?php selected($orderby_tab[$i], 'rand'); ?>><?php _e('rand');?></option>
            <option id="post_comment" <?php selected($orderby_tab[$i], 'comment_count'); ?>><?php _e('comment_count');?></option>
            </select>
            </p>
            <p>             
                <input class="checkbox" type="checkbox" <?php checked(isset($instance['show_image_tab' . $i ]) ? $instance['show_image_tab' . $i ] : 0 ); ?> id="<?php echo $this->get_field_id('show_image_tab' . $i ); ?>" name="<?php echo $this->get_field_name('show_image_tab' . $i ); ?>" />
                <label for="<?php echo $this->get_field_id('show_image_tab' . $i ); ?>"><?php _e('Display featured images?'); ?></label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('number_tab' . $i ); ?>"><?php _e('Number of posts to show :'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('number_tab' . $i ); ?>"
                       name="<?php echo $this->get_field_name('number_tab' . $i ); ?>" type="text"
                       value="<?php echo $number_tab[$i]; ?>"/>
            </p>
            <?php
        endfor;
    }
// Update settings variables
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $count_tabs = 3;
        for ($i = 1; $i <= $count_tabs; $i ++):
            $instance['title_tab' . $i ] = strip_tags($new_instance['title_tab' . $i ]);
            $instance['content_type_tab' . $i ] = strip_tags($new_instance['content_type_tab' . $i ]);
            $instance['category_tab' . $i ] = strip_tags($new_instance['category_tab' . $i ]);
            $instance['order_tab' . $i ] = strip_tags($new_instance['order_tab' . $i ]);
            $instance['orderby_tab' . $i ] = strip_tags($new_instance['orderby_tab' . $i ]);
            $instance['show_image_tab' . $i ] = isset($new_instance['show_image_tab' . $i ]);
            $instance['number_tab' . $i ] = strip_tags($new_instance['number_tab' . $i ]);
        endfor;
        return $instance;
    }
// Output widget
    function widget($args, $instance) {
        wp_register_style('tabs_widget_css', plugins_url('css/tabs_widget.css', __FILE__)); // register css file
        wp_register_script('tabs_widget_js', plugins_url('js/tabs_widget.js', __FILE__), array('jquery')); // register javascript file
        wp_enqueue_style('tabs_widget_css');
        wp_enqueue_script('tabs_widget_js');
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'); // register jQuery for tabs
        wp_enqueue_script('jquery');
        extract($args, EXTR_SKIP);
        ?>
        <ul class="tabs">
            <li class="active"><a href="#tab1"><?php echo $instance['title_tab1']; ?></a></li>
            <li><a href="#tab2"><?php echo $instance['title_tab2']; ?></a></li>
            <li><a href="#tab3"><?php echo $instance['title_tab3']; ?></a></li>
        </ul>
        <?php $count_tabs = 3; ?>
        <div class="tab_container">
        <?php for ($i = 1; $i <= $count_tabs; $i ++): ?>

                <div id="tab<?php echo $i ?>" class="tab_content" >
                    <ul>
                        <?php
                        $query = new WP_Query(array(
                            'posts_per_page' => $instance['number_tab' . $i ],
                            'post_type' => $instance['content_type_tab' . $i ],
                            'order' => $instance['order_tab' . $i . ''],
                            'category_name' => $instance['category_tab' . $i ],
                            'orderby' => $instance['orderby_tab' . $i ]
                        ));
                        ?>
                        <?php if ($query->have_posts()): while ($query->have_posts()) : $query->the_post(); ?>
                            <div class="tabs-post">
                                <li>
                                    <?php if ($instance['show_image_tab' . $i ] == 'yes'): ?>
                                        <div class="thumbnail">
                                        <?php echo the_post_thumbnail(array(50, 50)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="content">
                                    <a class="post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                    <div class="post-content"><?php the_content(); ?></div>
                                    </div>
                                </li>
                            </div>
                        <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </div>

        <?php endfor; ?>
        </div>
        <div class="tab-clear"></div>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("tabs_widget");'));

