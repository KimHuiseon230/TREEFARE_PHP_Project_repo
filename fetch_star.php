<?php
function fetch_star($rating)
{
  $output = "";
  $emoji_star = "⭐";
  $emoji_gray_star = "☆";

  for ($i = 1; $i <= 5; ++$i) {
    if ($i <= $rating) {
      $output .= $emoji_star;
    } else {
      $output .= $emoji_gray_star;
    }
  }

  return $output;
}
