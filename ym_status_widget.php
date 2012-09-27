<?php
/**
 * Search Content widget
 *
 * @package default
 * */

    class YM_Status_Widget extends WP_Widget {

        private $opts = array();

        public function __construct() {
            $widget_ops = array('classname' => 'YM_Status_Widget', 'description' => 'Widget for displaying Yahoo Messenger online status');

            parent::WP_Widget(/* Base ID */'YM_Status_Widget', /* Name */ 'YM_Status_Widget', array('description' => 'Widget for displaying Yahoo Messenger online status'));

            $this->opts = get_option('ym_status');          
        }

        public function widget($args, $instance) {
            // outputs the content of the widget
            extract($args);

            $instance = wp_parse_args((array) $instance);
            $title = apply_filters('widget_title', $instance['title']);
            $users = $instance['yahoo_users'];
            $opts = $this->opts;            

            echo $before_widget;

            if ($title) {
                echo $before_title . $title . $after_title;
            }
			$i = 0;
			if (!empty($users)) :
				foreach ($users as $key => $user):
				
					if ($i >= $instance['num_user'])
						break;
					if (empty($user))
						continue;
				?>
				<p>
					<?php if ($opts['action'] == 'sendweb'): ?>
						<a href="http://edit.yahoo.com/config/send_webmesg?.target=<?php echo $user; ?>">
						<?php else: ?>
							<a href="ymsgr:<?php echo "sendIM" ?>?<?php echo $user; ?>">
							<?php endif; ?>
							<?php if ($opts['image'] == 'custom'): ?>
								<?php if (YMStatus::IsOnline($opts['yahooid'])): ?>
									<img src="<?php echo $opts['custom']['online'] ?>" />
								<?php else: ?>
									<img src="<?php echo $opts['custom']['offline'] ?>" />
								<?php endif; ?>
							<?php else: ?>
								<img src="http://opi.yahoo.com/online?u=<?php echo $user ?>&m=g&t=<?php echo $opts['image'] ?>"/>
							<?php endif ?>      
						</a>
				</p>

				<?php
				$i++;
				endforeach;
			endif;
            echo $after_widget;
        }

        public function form($instance) {
            // outputs the options form on admin
            $instance = wp_parse_args((array) $instance, array('title' => '', 'num_user' => true, 'yahoo_users' => true));
            $title = apply_filters('widget_title', $instance['title']);
            $num_user = (int) $instance['num_user'];
            $yahoo_users = $instance['yahoo_users'];
            
            ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('num_user'); ?>"><?php _e('Number of Users:'); ?> </label>
                 <select class="widefat" id="<?php echo $this->get_field_id('num_user'); ?>" name="<?php echo $this->get_field_name('num_user'); ?>">
                        <?php for ($i=1;$i<=$num_user+3;$i++) : ?>
                        <option value="<?php echo $i; ?>" <?php echo ($num_user == $i) ? 'selected="selected"' : "" ?>> <?php echo $i; ?> </option>
                        <?php endfor; ?>                        
                </select>
               
            </p>
            <p>
            <div id="yahoo_users">
                 <?php
            for ($i=0;$i<$num_user;$i++) :            
				$j = $i + 1;
			?>				
				<label for="<?php echo $this->get_field_name('yahoo_users[]'); ?>"><?php _e("User $j:"); ?> </label>
				<input class="widefat" id="<?php echo $this->get_field_id("yahoo_users-$i"); ?>" type="text" name="<?php echo $this->get_field_name('yahoo_users'); ?>[]" value="<?php echo (isset($yahoo_users[$i])) ? $yahoo_users[$i] : ''; ?>" />
            <?php
				
            endfor;
            ?>
            </div>
            </p>

            <?php
        }

        public function update($new_instance, $old_instance) {
            // processes widget options to be saved
            $instance = $old_instance;
            $instance = wp_parse_args((array) $instance);
            
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['num_user']= strip_tags($new_instance['num_user']);
            
            foreach ($new_instance['yahoo_users'] as $key=>$value) {
                $instance['yahoo_users'][$key] = strip_tags($value);
            }
            
            return $instance;
        }
    }
?>