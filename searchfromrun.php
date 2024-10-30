<?php

if (!defined('ABSPATH')) {
    die("Can't access");
}

    global $wpdb;
    require_once "Careerjet_API.php";
    //$api = new EasySearchCareerjetJobs('en_IN');
    $api = new ESCJ('en_IN');
    
    $result_form = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}SF_form_setting WHERE status = %s ORDER BY id DESC", '1'));
    
        $box_width = $result_form->box_width;
        $bg_color = $result_form->bg_color;
        $text_color = $result_form->text_color;
        $border_color = $result_form->border_color;
        $link_color = $result_form->link_color;
        $title = $result_form->title;
        $font = $result_form->font;
?>
    <style>
        .container-css {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
            padding:25px;
        }
        .box-design {
            width: <?php echo $box_width; ?>px;
            background: <?php echo esc_attr($bg_color); ?>;
            color: <?php echo esc_attr($text_color); ?>;
            border: 2px solid <?php echo esc_attr($border_color); ?>;
            font-family: <?php echo esc_attr($font); ?>;
            text-align: left;
            padding: 20px;
            box-shadow: 5px 5px 5px rgba(0.3, 0.3, 0.3, 0.3);
            box-sizing: border-box;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        .box-design p {
            line-height: 1.5;
            margin-bottom: 10px;
        }
        .box-design a.learn-more-btn {
            margin-top: auto;
            align-self: start;
            border: 2px solid #3f3f46;
            padding: 2px 8px;
            border-radius: 7px;
            text-decoration: none;
            color: #3f3f46;
            transition: transform 0.3s; 
        }
        .box-design a.learn-more-btn:hover {
            transform: scale(1.1); /* Zoom in on hover */
        }
        .paging-container-css {
            margin-top: auto;
            text-align: center; /* Center pagination on small screens */
        }
        .paging-container-css a {
            display: inline-block;
            padding: 2px 12px;
            background: #14213d;
            color: #fff;
            border: 1px solid #2c3e50;
            border-radius: 5px;
            text-decoration: none;
            margin: 5px; /* Add some margin between pagination links */
        }
        .paging-container-css a:hover {
            background: #fff !important;
            color: #000!important;
        }
        .containers-row{
            margin-bottom: 30px;
        }
        .border_css:hover{
            border:solid 1px #000;
            color:#000!important;
        }
        @media (min-width: 768px) {
            /* Two columns on large screens */
            .box-design {
                width: calc(50% - 20px);
            }
        }
    </style>
     <div class="container">
         <h2><?php echo esc_html( $title ); ?></h2>

        <form class="form-inline" action="" method="POST">
            <div class="form-group">
                <label>Keywords: </label>
                <input type="text" class="form-control" placeholder="Enter Keyword.." name="keywords">
            </div>
            <div class="form-group">
                <label>Location:</label>
                <input type="text" class="form-control" placeholder="Enter location.." name="location">
            </div> 
            <?php wp_nonce_field('careerjet_search', 'careerjet_nonce'); ?>
            <input type="submit" class="btn btn-default" name="key_sub" value="Submit">
        </form>
    </div>
    
<?php
//if (isset($_POST['key_sub']) && wp_verify_nonce($_POST['careerjet_nonce'], 'careerjet_search')) {
if (($_GET['key_sub'] == 'key_sub') || wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['careerjet_nonce'])), 'careerjet_search')) {

        $page_sub = isset($_GET['pages']) ? max(1, intval($_GET['pages'])) : 1;
        if($_GET['keywords_sub']=='' && $_GET['location_sub']=='' ){
            $keywords_sub = isset($_POST['keywords']) ? sanitize_text_field($_POST['keywords']) : '';
            $location_sub = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        }else{
           $keywords_sub = isset($_GET['keywords_sub']) ? sanitize_text_field($_GET['keywords_sub']) : '';
   //        $keywords_sub = $_GET['keywords_sub'];
           //$location_sub = $_GET['location_sub'];
           $location_sub = isset($_GET['location_sub']) ? sanitize_text_field($_GET['location_sub']) : '';
        }

        $result_sub = $api->search(array(
              'keywords' => $keywords_sub,
              'location' => $location_sub,
              'page' => $page_sub,
              'affid' => '8cbbdbcaceb0170eca2ac69e5f4abd7d',
            ));
            
        if ($result_sub->type == 'JOBS') {
        echo '<div class="container">';
        echo "Found " . esc_html( $result_sub->hits ) . " jobs";
        echo " on " . esc_html( $result_sub->pages ) . " pages\n";
        echo '</div>';
        
        echo '<div class="container-css">';
        
        $jobs = $result_sub->jobs;
        foreach ($jobs as $job) {
            echo '<div class="box-design">';
            echo '<h3>' . esc_html($job->title) . '</h3>';
            echo '<p><b>Location: </b>' . esc_html($job->locations) . '</p>';
            echo '<p><b>Company:</b> ' . esc_html($job->company) . '</p>';
            echo '<p><b>Salary: </b>' . (isset($job->salary) ? esc_html($job->salary) : 'Not mentioned') . '</p>';
            echo '<p><b>Date: </b>' . esc_html($job->date) . '</p>';
            $description = implode(' ', array_slice(explode(' ', esc_html($job->description)), 0, 30));
            echo '<p><b>Job Description: </b><br>' . esc_html( $description ) . '...</p>';
            echo '<a class="learn-more-btn" href="' . esc_url($job->url) . '" target="_blank"><b>Learn More</b></a>';
            echo "</div>";
        }
        echo '</div>';
        echo '<div class="paging-container-css">';
        $key_sub = "key_sub";
        if ($page_sub > 1) {
            $previousPage = $page_sub - 1;
            echo '<a href="?keywords_sub=' . urlencode($keywords_sub) . '&location_sub=' . urlencode($location_sub) . '&key_sub=' . esc_attr($key_sub) . '&pages=' . esc_attr($previousPage) . '">Previous Page</a> ';
        }
        if ($page_sub < $result_sub->pages) {
            $nextPage = $page_sub + 1;
            echo '<a href="?keywords_sub=' . urlencode($keywords_sub) . '&location_sub=' . urlencode($location_sub) . '&key_sub=' . esc_attr($key_sub) . '&pages=' . esc_attr($nextPage) . '">Next Page</a>';
        }
        echo '</div>';
    }    
            
 }else{
            $page = isset($_GET['pages']) ? max(1, intval($_GET['pages'])) : 1;
            $result_normal = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}SF_form_setting WHERE status = %s ORDER BY id DESC", '1'));
            
            $keywords_normal = $result_normal->keywords;
            $location_normal = $result_normal->location;
            
            $result = $api->search(array(
                  'keywords' => $keywords_normal,
                  'location' => $location_normal,
                  'page' => $page,
                  'affid' => '8cbbdbcaceb0170eca2ac69e5f4abd7d',
                ));
                
            if ($result->type == 'JOBS') {
            
            echo '<div class="container">';
            echo "Found " . esc_html($result->hits) . " jobs";
            echo " on " .  esc_html($result->pages) . " pages\n";
            echo '</div>';
            echo '<div class="container-css">';
            
            $jobs = $result->jobs;
            foreach ($jobs as $job) {
                echo '<div class="box-design">';
                echo '<h3>' . esc_html($job->title) . '</h3>';
                echo '<p><b>Location: </b>' . esc_html($job->locations) . '</p>';
                echo '<p><b>Company:</b> ' . esc_html($job->company) . '</p>';
                echo '<p><b>Salary: </b>' . (isset($job->salary) ? esc_html($job->salary) : 'Not mentioned') . '</p>';
                echo '<p><b>Date: </b>' . esc_html($job->date) . '</p>';
                $description = implode(' ', array_slice(explode(' ', esc_html($job->description)), 0, 30));
                echo '<p><b>Job Description: </b><br>' . esc_html( $description ). '...</p>';
                echo '<a class="learn-more-btn" href="' . esc_url($job->url) . '" target="_blank"><b>Learn More</b></a>';
                echo "</div>";

            }
            echo '</div>';
            echo '<div class="paging-container-css">';
            if ($page > 1) {
                $previousPage = $page - 1;
                echo '<a href="?keywords=' . urlencode($keywords_normal) . '&location=' . urlencode($location_normal) . '&pages=' . esc_attr($previousPage) . '">Previous Page</a> ';
            }
            if ($page < $result->pages) {
                $nextPage = $page + 1;
                echo '<a href="?keywords=' . urlencode($keywords_normal) . '&location=' . urlencode($location_normal) . '&pages=' . esc_attr($nextPage) . '">Next Page</a>';
            }
        echo '</div>';
        }    
                
    }
    
    
    
?>
