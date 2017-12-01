<?php

/*
 * Plugin Name: FYC Promo Video Player
 * Plugin URI: http://tubes.fuckyoucash.com
 * Description: Shortcode to add a video player for FYC promo videos.
 * Version: 0.0.1
 * Author: Fuck You Cash
 * Author URI: http://tubes.fuckyoucash.com
 *
 *
 * USAGE:
 * [fyc-player video_id=66599]
 *
 */

function fyc_fetch_video_data($video_id) {
  $fp = gzopen("http://tubes.fuckyoucash.com/data/{$video_id}", "r");
  $contents = "";
  while ($chunk = gzread($fp, 256000)) {
    $contents .= $chunk;
  }
  gzclose($fp);
  return json_decode($contents);
}

function fyc_show_video_player($attributes, $content = null) {
  $video_data = fyc_fetch_video_data($attributes["video_id"]);
  $width = $attributes["width"] == null ? "100%" : $width;

  $output = "
    <video poster='{$video_data->image_url}' width='{$width}' controls>
      <source src='{$video_data->video_url}' type='video/mp4'>
    </video>
  ";

  return $output;
}

add_shortcode("fyc-player", "fyc_show_video_player");

?>
