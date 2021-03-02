<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
<title><?php echo xml_convert($feed_name); ?></title>
<link><?php echo $feed_url; ?></link>
<description><?php echo convert_to_xml_character(xml_convert($page_description)); ?></description>
<dc:language><?php echo $page_language; ?></dc:language>
<dc:creator><?php echo $creator_email; ?></dc:creator>
<dc:rights><?php echo convert_to_xml_character(xml_convert($this->settings->copyright)); ?></dc:rights>
<?php foreach ($products as $product):
    $product_details= get_product_details($product->id, $this->selected_lang->id,true); ?>
<item>
    <title><?php echo convert_to_xml_character(xml_convert(get_product_title($product))); ?></title>
    <link><?php echo generate_product_url($product); ?></link>
    <guid><?php echo generate_product_url($product); ?></guid>
    <description><![CDATA[<div class="price"><p>✔ <?php echo trans("price") . ": " . price_formatted($product->price,$product->currency); ?></p></div><div class="description"><?= !empty($product_details) ? $product_details->description : ''; ?></div>]]></description>
<?php
$image_path = "";
$file_size = 12;
if (!empty($product) && !empty($product->image)) {
    $image = $product->image;
    if (!empty($image)) {
        $image_array = explode("::", $image);
        if (!empty($image_array[0]) && !empty($image_array[1])) {
            if ($image_array[0] == "aws_s3") {
                $image_path = $this->aws_base_url . "uploads/images/" . $image_array[1];
            } else {
                $image_path = base_url() . "uploads/images/" . $image_array[1];
                $file_size = @filesize(FCPATH . "uploads/images/" . $image_array[1]);
            }
        }
    }
}
$image_path = str_replace( 'https://', 'http://', $image_path );
if (!empty($image_path)):?>
    <enclosure url="<?php echo convert_to_xml_character($image_path); ?>" length="<?php echo (isset($file_size)) ? $file_size : '';  ?>" type="image/jpeg"/>
<?php endif; ?>
    <pubDate><?php echo date('r', strtotime($product->created_at)); ?></pubDate>
    <dc:creator><?php echo convert_to_xml_character(get_shop_name_product($product)); ?></dc:creator>
</item>
<?php endforeach; ?>
</channel>
</rss>
