<?php
namespace Blog\Model;

class BlogPostFormat
{
  // build meta description from body description
  public function metaDescriptionFromBody($postBody) {
    $cleanString = strip_tags($postBody);

    if (strlen($cleanString) <= 160) {
      $metaDesc = $cleanString;
    } else {
      $cleanString = substr($cleanString, 0, 160);
      $metaDesc = preg_replace('/\n/', '', substr($cleanString, 0, strrpos($cleanString, ' ')));
      if (!preg_match('/[:;,0-9!\.\?]/', substr($metaDesc, -1))) {
        $metaDesc = $metaDesc.'.';
      }
    }

    return $metaDesc;
  }

  // add url for tags
  public function keyWordTags($tags) {
    if (!empty($tags)) {
      $tagsLinks = '';
      $tagArray = str_replace(' ', '', explode(',', $tags));

      foreach ($tagArray as $key => $value) {
        $tagsLinks .= '<a href="/blog/tags/'.$value.'">'.$value.'</a> ';
      }

      return $tagsLinks;
    }
  }

  // homepage short description
  public function homepageDescriptionFromBody($postBody) {
    $cleanString = strip_tags($postBody, '<p><i><em><strong><bold>');

    if (strlen($cleanString) <= 320) {
      $metaDesc = $cleanString;
    } else {
      $cleanString = substr($cleanString, 0, 320);
      $metaDesc = preg_replace('/\n/', '', substr($cleanString, 0, strrpos($cleanString, ' ')));
      if (!preg_match('/[:;,0-9!\.\?]/', substr($metaDesc, -1))) {
        $metaDesc = $metaDesc.'...';
      }
    }

    return $metaDesc;
  }
}
