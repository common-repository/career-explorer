<?php 

if (!defined('ABSPATH')) {
    die("Can't access");
}

?>
<style>
.containers-css {
    background-color: #F2F6FB;
    border: 1px solid #8DC7FB;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    max-width: 460px;
    padding: 0px;
    margin-bottom: 15px;
    margin-top: 15px;
}

.form-css {
    display: flex;
    flex-direction: column;
}

.form-css label {
    display: flex;
    justify-content: space-between;
    margin: 5px 20px;
    text-align: left;
}

.form-css input[type="number"],
.form-css select,
.form-css input[type="color"],
.form-css input[type="text"] {
    width: 40%;
    padding: 2px;
    margin: 0;
}

.form-css input[type="submit"] {
    background-color: #2271b1;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 20px;
    float: right;
    margin-right: 43px;
}

.form-css input[type="submit"]:hover {
    background-color: #fff;
    color: #2271b1;
    border: solid 1px #2271b1;
}
</style>
    
<div class="containers-css">
   <h2 style="text-align:center">Customize Your JobBox</h2>
   <form class="form-css" action="" method="post">
       
       <?php wp_nonce_field( 'submit_form', 'submit_form_nonce' ); ?>
   
       <?php 
        global $wpdb; 
        $result_normal = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}SF_form_setting ORDER BY id DESC");
        $bg_color = sanitize_hex_color($result_normal->bg_color);
        $link_color = sanitize_hex_color($result_normal->link_color);
        $border_color = sanitize_hex_color($result_normal->border_color);
        $text_color = sanitize_hex_color($result_normal->text_color);
        $box_width = intval($result_normal->box_width);
        $title = htmlspecialchars($result_normal->title);
        $location = htmlspecialchars($result_normal->location);
        $font = htmlspecialchars($result_normal->font);
        $keywords = htmlspecialchars($result_normal->keywords);


       ?>
       
         <label for="keywords"><b>Search Keywords:</b>
        <input type="text" id="keywords" name="keywords" placeholder="PHP Developer" 
            value="<?php echo esc_attr($keywords); ?>" 
            pattern="[a-zA-Z\s\-.,()]+"
            title="Only alphabets, spaces, hyphens, commas, periods, and parentheses are allowed"
            required>
        </label>

        <label for="location"><b>Location:</b>
        <input type="text" id="location" name="location" placeholder="Indore" 
            value="<?php echo esc_attr($location); ?>"
            pattern="[a-zA-Z\s\-.,]+"
            title="Only alphabets, spaces, hyphens, commas, and periods are allowed"
            required>
        </label>

      <label for="title"><b>Box Title:</b>
      <input type="text" id="title" name="title" placeholder="Job Search" value="<?php echo esc_html($title); ?>" required>
      </label>
      <label for="box_width"><b>Width of box:</b>
      <input type="number" id="box_width" name="box_width" min="100" placeholder="1000" value="<?php echo esc_attr($box_width); ?>">
      </label>
      <label for="bg-color"><b>Background Color:</b>
      <input type="color" id="bg-color" name="bg-color" value="<?php echo esc_attr($bg_color); ?>">
      </label>
      <label for="border-color">
      <b> Border Color:</b>
      <input type="color" id="border-color" name="border-color" value="<?php echo esc_attr($border_color); ?>">
      </label>
      <label for="font">
         <b>Font Style:</b>
        <select id="font" name="font">
        <option value="Arial, sans-serif" <?php if($font =="Arial, sans-serif"){echo "selected";} ?> >Arial</option>
        <option value="Times New Roman, serif" <?php if($font =="Times New Roman, serif"){echo "selected";} ?> >Times New Roman</option>
        <option value="Verdana, sans-serif" <?php if($font =="Verdana, sans-serif"){echo "selected";} ?> >Verdana</option>
        <option value="Helvetica, sans-serif" <?php if($font =="Helvetica, sans-serif"){echo "selected";} ?> >Helvetica</option>
        <option value="Georgia, serif" <?php if($font =="Georgia, serif"){echo "selected";} ?> >Georgia</option>
        <option value="Roboto, sans-serif" <?php if($font =="Roboto, sans-serif"){echo "selected";} ?> >Roboto</option>
        <option value="Open Sans, sans-serif" <?php if($font =="Open Sans, sans-serif"){echo "selected";} ?> >Open Sans</option>
        <option value="Cabin, sans-serif" <?php if($font =="Cabin, sans-serif"){echo "selected";} ?> >Cabin</option>
        <option value="Lato, sans-serif" <?php if($font =="Lato, sans-serif"){echo "selected";} ?> >Lato</option>
        <option value="Garamond, serif" <?php if($font =="Garamond, serif"){echo "selected";} ?> >Garamond</option>
        <option value="Courier New, monospace" <?php if($font =="Courier New, monospace"){echo "selected";} ?> >Courier New</option>
        <option value="Impact, sans-serif" <?php if($font =="Impact, sans-serif"){echo "selected";} ?> >Impact</option>
        <option value="Palatino, serif" <?php if($font =="Palatino, serif"){echo "selected";} ?> >Palatino</option>
        <option value="Trebuchet MS, sans-serif" <?php if($font =="Trebuchet MS, sans-serif"){echo "selected";} ?> >Trebuchet MS</option>
        <option value="Lucida Console, monospace" <?php if($font =="Lucida Console, monospace"){echo "selected";} ?> >Lucida Console</option>
        <option value="Arial Black, sans-serif" <?php if($font =="Arial Black, sans-serif"){echo "selected";} ?> >Arial Black</option>
        <option value="Century Gothic, sans-serif" <?php if($font =="Century Gothic, sans-serif"){echo "selected";} ?> >Century Gothic</option>
        <option value="Book Antiqua, serif" <?php if($font =="Book Antiqua, serif"){echo "selected";} ?> >Book Antiqua</option>
        <option value="Comic Sans MS, cursive" <?php if($font =="Comic Sans MS, cursive"){echo "selected";} ?> >Comic Sans MS</option>
        <option value="Franklin Gothic Medium, sans-serif" <?php if($font =="Franklin Gothic Medium, sans-serif"){echo "selected";} ?> >Franklin Gothic Medium</option>
        </select>
      </label>
      <label for="text-color">
      <b> Text Color:</b>
      <input type="color" id="text-color" name="text-color" value="<?php echo esc_attr($text_color); ?>">
      </label>
      <label for="link-color">
      <b>Link Color:</b>
      <input type="color" id="link-color" name="link-color" value="<?php echo esc_attr($link_color); ?>">
      </label>
      <label>Use this shortcode [TCJSPE] to display the result.<img src="<?php echo esc_url(plugin_dir_url(__FILE__)) . 'assets/images/copyicon.png'; ?>" width="12" height="16px" onclick="copyToClipboard()"></label>
     <span id="copyMessage" style="display:none; color: green;  margin: 8px; margin-left:300px" >Copied to clipboard!</span>
      <div>
         <input type="submit" name="submit" value="Apply">                
      </div>
   </form>
</div>
    
<script>
    function copyToClipboard() {
        event.preventDefault();
        var tempTextarea = document.createElement("textarea");
        tempTextarea.value = "[TCJSPE]";
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(tempTextarea);
        var copyMessage = document.getElementById("copyMessage");
        copyMessage.style.display = "inline";
        setTimeout(function() {
            copyMessage.style.display = "none";
        }, 2000);
    }
</script>

<?php
global $wpdb; 
//if (isset($_POST['submit'])) {
    if ( isset( $_POST['submit'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['submit_form_nonce'] ) ), 'submit_form' ) ) {
    $entry_data = array(
        'box_width' => sanitize_text_field($_POST['box_width']), 
        'bg_color' => sanitize_text_field($_POST['bg-color']),
        'border_color' => sanitize_text_field($_POST['border-color']),
        'font' => sanitize_text_field($_POST['font']),
        'text_color' => sanitize_text_field($_POST['text-color']),
        'link_color' => sanitize_text_field($_POST['link-color']),
        'title' => sanitize_text_field($_POST['title']),
        'status' => '1',
        'keywords' => sanitize_text_field($_POST['keywords']),
        'location' => sanitize_text_field($_POST['location']),
        );

    $table_name = $wpdb->prefix . 'SF_form_setting'; 
    $wpdb->insert($table_name, $entry_data);

    if ($wpdb->insert_id) {
          echo '<div class="alert alert-success">Data submited.</div>'; ?>
            <script>
                setTimeout(function () {
                    window.location.href = '<?php echo esc_url(site_url()); ?>/wp-admin/admin.php?page=customize_form';
                        }, 1000); // 3000 milliseconds = 3 seconds
            </script>
          
     <?php } else {
          echo '<div class="alert alert-danger">error in submission.</div>'; ?>
          <script>
                setTimeout(function () {
                    window.location.href = '<?php echo esc_url(site_url()); ?>/wp-admin/admin.php?page=customize_form';
                        }, 1000); // 3000 milliseconds = 3 seconds
            </script>
    <?php        
     }
}
?>