<?php
// +------------------------------------------------------------------------+
// | class.upload.php                                                       |
// +------------------------------------------------------------------------+
// | Copyright (c) Colin Verot 2003-2010. All rights reserved.              |
// | Version       0.31                                                     |
// | Last modified 11/04/2011                                               |
// | Email         colin@verot.net                                          |
// | Web           http://www.verot.net                                     |
// +------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify   |
// | it under the terms of the GNU General Public License version 2 as      |
// | published by the Free Software Foundation.                             |
// |                                                                        |
// | This program is distributed in the hope that it will be useful,        |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of         |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          |
// | GNU General Public License for more details.                           |
// |                                                                        |
// | You should have received a copy of the GNU General Public License      |
// | along with this program; if not, write to the                          |
// |   Free Software Foundation, Inc., 59 Temple Place, Suite 330,          |
// |   Boston, MA 02111-1307 USA                                            |
// |                                                                        |
// | Please give credit on sites that use class.upload and submit changes   |
// | of the script so other people can use them as well.                    |
// | This script is free to use, don't abuse.                               |
// +------------------------------------------------------------------------+
//

/**
 * Class upload
 *
 * @version   0.31
 * @author    Colin Verot <colin@verot.net>
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright Colin Verot
 * @package   cmf
 * @subpackage external
 */

/**
 * Class upload
 *
 * <b>What does it do?</b>
 *
 * It manages file uploads for you. In short, it manages the uploaded file,
 * and allows you to do whatever you want with the file, especially if it
 * is an image, and as many times as you want.
 *
 * It is the ideal class to quickly integrate file upload in your site.
 * If the file is an image, you can convert, resize, crop it in many ways.
 * You can also apply filters, add borders, text, watermarks, etc...
 * That's all you need for a gallery script for instance. Supported formats
 * are PNG, JPG, GIF and BMP.
 *
 * You can also use the class to work on local files, which is especially
 * useful to use the image manipulation features. The class also supports
 * Flash uploaders.
 *
 * The class works with PHP 4 and 5, and its error messages can
 * be localized at will.
 *
 * <b>How does it work?</b>
 *
 * You instanciate the class with the $_FILES['my_field'] array
 * where my_field is the field name from your upload form.
 * The class will check if the original file has been uploaded
 * to its temporary location (alternatively, you can instanciate
 * the class with a local filename).
 *
 * You can then set a number of processing variables to act on the file.
 * For instance, you can rename the file, and if it is an image,
 * convert and resize it in many ways.
 * You can also set what will the class do if the file already exists.
 *
 * Then you call the function {@link process} to actually perform the actions
 * according to the processing parameters you set above.
 * It will create new instances of the original file,
 * so the original file remains the same between each process.
 * The file will be manipulated, and copied to the given location.
 * The processing variables will be reset once it is done.
 *
 * You can repeat setting up a new set of processing variables,
 * and calling {@link process} again as many times as you want.
 * When you have finished, you can call {@link clean} to delete
 * the original uploaded file.
 *
 * If you don't set any processing parameters and call {@link process}
 * just after instanciating the class. The uploaded file will be simply
 * copied to the given location without any alteration or checks.
 *
 * Don't forget to add <i>enctype="multipart/form-data"</i> in your form
 * tag <form> if you want your form to upload the file.
 *
 * <b>How to use it?</b><br>
 * Create a simple HTML file, with a form such as:
 * <pre>
 * <form enctype="multipart/form-data" method="post" action="upload.php">
 *   <input type="file" size="32" name="image_field" value="">
 *   <input type="submit" name="Submit" value="upload">
 * </form>
 * </pre>
 * Create a file called upload.php:
 * <pre>
 *  $handle = new upload($_FILES['image_field']);
 *  if ($handle->uploaded) {
 *      $handle->file_new_name_body   = 'image_resized';
 *      $handle->image_resize         = true;
 *      $handle->image_x              = 100;
 *      $handle->image_ratio_y        = true;
 *      $handle->process('/home/user/files/');
 *      if ($handle->processed) {
 *          echo 'image resized';
 *          $handle->clean();
 *      } else {
 *          echo 'error : ' . $handle->error;
 *      }
 *  }
 * </pre>
 *
 * <b>How to process local files?</b><br>
 * Use the class as following, the rest being the same as above:
 * <pre>
 *  $handle = new upload('/home/user/myfile.jpg');
 * </pre>
 *
 * <b>How to set the language?</b><br>
 * Instantiate the class with a second argument being the language code:
 * <pre>
 *  $handle = new upload($_FILES['image_field'], 'fr_FR');
 *  $handle = new upload('/home/user/myfile.jpg', 'fr_FR');
 * </pre>
 *
 * <b>How to output the resulting file or picture directly to the browser?</b><br>
 * Simply call {@link process}() without an argument (or with null as first argument):
 * <pre>
 *  $handle = new upload($_FILES['image_field']);
 *  header('Content-type: ' . $handle->file_src_mime);
 *  echo $handle->Process();
 *  die();
 * </pre>
 * Or if you want to force the download of the file:
 * <pre>
 *  $handle = new upload($_FILES['image_field']);
 *  header('Content-type: ' . $handle->file_src_mime);
 *  header("Content-Disposition: attachment; filename=".rawurlencode($handle->file_src_name).";");
 *  echo $handle->Process();
 *  die();
 * </pre>
 *
 * <b>Processing parameters</b> (reset after each process)
 * <ul>
 *  <li><b>{@link file_new_name_body}</b> replaces the name body (default: null)<br>
 *  <pre>$handle->file_new_name_body = 'new name';</pre></li>
 *  <li><b>{@link file_name_body_add}</b> appends to the name body (default: null)<br>
 *  <pre>$handle->file_name_body_add = '_uploaded';</pre></li>
 *  <li><b>{@link file_name_body_pre}</b> prepends to the name body (default: null)<br>
 *  <pre>$handle->file_name_body_pre = 'thumb_';</pre></li>
 *  <li><b>{@link file_new_name_ext}</b> replaces the file extension (default: null)<br>
 *  <pre>$handle->file_new_name_ext = 'txt';</pre></li>
 *  <li><b>{@link file_safe_name}</b> formats the filename (spaces changed to _) (default: true)<br>
 *  <pre>$handle->file_safe_name = true;</pre></li>
 *  <li><b>{@link file_force_extension}</b> forces an extension if there is't any (default: true)<br>
 *  <pre>$handle->file_force_extension = true;</pre></li>
 *  <li><b>{@link file_overwrite}</b> sets behaviour if file already exists (default: false)<br>
 *  <pre>$handle->file_overwrite = true;</pre></li>
 *  <li><b>{@link file_auto_rename}</b> automatically renames file if it already exists (default: true)<br>
 *  <pre>$handle->file_auto_rename = true;</pre></li>
 *  <li><b>{@link dir_auto_create}</b> automatically creates destination directory if missing (default: true)<br>
 *  <pre>$handle->auto_create_dir = true;</pre></li>
 *  <li><b>{@link dir_auto_chmod}</b> automatically attempts to chmod the destination directory if not writeable (default: true)<br>
 *  <pre>$handle->dir_auto_chmod = true;</pre></li>
 *  <li><b>{@link dir_chmod}</b> chmod used when creating directory or if directory not writeable (default: 0777)<br>
 *  <pre>$handle->dir_chmod = 0777;</pre></li>
 *  <li><b>{@link file_max_size}</b> sets maximum upload size (default: upload_max_filesize from php.ini)<br>
 *  <pre>$handle->file_max_size = '1024'; // 1KB</pre></li>
 *  <li><b>{@link mime_check}</b> sets if the class check the MIME against the {@link allowed} list (default: true)<br>
 *  <pre>$handle->mime_check = true;</pre></li>
 *  <li><b>{@link no_script}</b> sets if the class turns scripts into text files (default: true)<br>
 *  <pre>$handle->no_script = false;</pre></li>
 *  <li><b>{@link allowed}</b> array of allowed mime-types (or one string). wildcard accepted, as in image/* (default: check {@link Init})<br>
 *  <pre>$handle->allowed = array('application/pdf','application/msword', 'image/*');</pre></li>
 *  <li><b>{@link forbidden}</b> array of forbidden mime-types (or one string). wildcard accepted, as in image/*  (default: check {@link Init})<br>
 *  <pre>$handle->forbidden = array('application/*');</pre></li>
 * </ul>
 * <ul>
 *  <li><b>{@link image_convert}</b> if set, image will be converted (possible values : ''|'png'|'jpeg'|'gif'|'bmp'; default: '')<br>
 *  <pre>$handle->image_convert = 'jpg';</pre></li>
 *  <li><b>{@link image_background_color}</b> if set, will forcibly fill transparent areas with the color, in hexadecimal (default: null)<br>
 *  <pre>$handle->image_background_color = '#FF00FF';</pre></li>
 *  <li><b>{@link image_default_color}</b> fallback color background color for non alpha-transparent output formats, such as JPEG or BMP, in hexadecimal (default: #FFFFFF)<br>
 *  <pre>$handle->image_default_color = '#FF00FF';</pre></li>
 *  <li><b>{@link jpeg_quality}</b> sets the compression quality for JPEG images (default: 85)<br>
 *  <pre>$handle->jpeg_quality = 50;</pre></li>
 *  <li><b>{@link jpeg_size}</b> if set to a size in bytes, will approximate {@link jpeg_quality} so the output image fits within the size (default: null)<br>
 *  <pre>$handle->jpeg_size = 3072;</pre></li>
 * </ul>
 * The following eight settings can be used to invalidate an upload if the file is an image (note that <i>open_basedir</i> restrictions prevent the use of these settings)
 * <ul>
 *  <li><b>{@link image_max_width}</b> if set to a dimension in pixels, the upload will be invalid if the image width is greater (default: null)<br>
 *  <pre>$handle->image_max_width = 200;</pre></li>
 *  <li><b>{@link image_max_height}</b> if set to a dimension in pixels, the upload will be invalid if the image height is greater (default: null)<br>
 *  <pre>$handle->image_max_height = 100;</pre></li>
 *  <li><b>{@link image_max_pixels}</b> if set to a number of pixels, the upload will be invalid if the image number of pixels is greater (default: null)<br>
 *  <pre>$handle->image_max_pixels = 50000;</pre></li>
 *  <li><b>{@link image_max_ratio}</b> if set to a aspect ratio (width/height), the upload will be invalid if the image apect ratio is greater (default: null)<br>
 *  <pre>$handle->image_max_ratio = 1.5;</pre></li>
 *  <li><b>{@link image_min_width}</b> if set to a dimension in pixels, the upload will be invalid if the image width is lower (default: null)<br>
 *  <pre>$handle->image_min_width = 100;</pre></li>
 *  <li><b>{@link image_min_height}</b> if set to a dimension in pixels, the upload will be invalid if the image height is lower (default: null)<br>
 *  <pre>$handle->image_min_height = 500;</pre></li>
 *  <li><b>{@link image_min_pixels}</b> if set to a number of pixels, the upload will be invalid if the image number of pixels is lower (default: null)<br>
 *  <pre>$handle->image_min_pixels = 20000;</pre></li>
 *  <li><b>{@link image_min_ratio}</b> if set to a aspect ratio (width/height), the upload will be invalid if the image apect ratio is lower (default: null)<br>
 *  <pre>$handle->image_min_ratio = 0.5;</pre></li>
 * </ul>
 * <ul>
 *  <li><b>{@link image_resize}</b> determines is an image will be resized (default: false)<br>
 *  <pre>$handle->image_resize = true;</pre></li>
 * </ul>
 *  The following variables are used only if {@link image_resize} == true
 * <ul>
 *  <li><b>{@link image_x}</b> destination image width (default: 150)<br>
 *  <pre>$handle->image_x = 100;</pre></li>
 *  <li><b>{@link image_y}</b> destination image height (default: 150)<br>
 *  <pre>$handle->image_y = 200;</pre></li>
 * </ul>
 *  Use either one of the following
 * <ul>
 *  <li><b>{@link image_ratio}</b> if true, resize image conserving the original sizes ratio, using {@link image_x} AND {@link image_y} as max sizes if true (default: false)<br>
 *  <pre>$handle->image_ratio = true;</pre></li>
 *  <li><b>{@link image_ratio_crop}</b> if true, resize image conserving the original sizes ratio, using {@link image_x} AND {@link image_y} as max sizes, and cropping excedent to fill the space. setting can also be a string, with one or more from 'TBLR', indicating which side of the image will be kept while cropping (default: false)<br>
 *  <pre>$handle->image_ratio_crop = true;</pre></li>
 *  <li><b>{@link image_ratio_fill}</b> if true, resize image conserving the original sizes ratio, using {@link image_x} AND {@link image_y} as max sizes, fitting the image in the space and coloring the remaining space. setting can also be a string, with one or more from 'TBLR', indicating which side of the space the image will be in (default: false)<br>
 *  <pre>$handle->image_ratio_fill = true;</pre></li>
 *  <li><b>{@link image_ratio_no_zoom_in}</b> same as {@link image_ratio}, but won't resize if the source image is smaller than {@link image_x} x {@link image_y} (default: false)<br>
 *  <pre>$handle->image_ratio_no_zoom_in = true;</pre></li>
 *  <li><b>{@link image_ratio_no_zoom_out}</b> same as {@link image_ratio}, but won't resize if the source image is bigger than {@link image_x} x {@link image_y} (default: false)<br>
 *  <pre>$handle->image_ratio_no_zoom_out = true;</pre></li>
 *  <li><b>{@link image_ratio_x}</b> if true, resize image, calculating {@link image_x} from {@link image_y} and conserving the original sizes ratio (default: false)<br>
 *  <pre>$handle->image_ratio_x = true;</pre></li>
 *  <li><b>{@link image_ratio_y}</b> if true, resize image, calculating {@link image_y} from {@link image_x} and conserving the original sizes ratio (default: false)<br>
 *  <pre>$handle->image_ratio_y = true;</pre></li>
 *  <li><b>{@link image_ratio_pixels}</b> if set to a long integer, resize image, calculating {@link image_y} and {@link image_x} to match a the number of pixels (default: false)<br>
 *  <pre>$handle->image_ratio_pixels = 25000;</pre></li>
 * </ul>
 *  The following image manipulations require GD2+
 * <ul>
 *  <li><b>{@link image_brightness}</b> if set, corrects the brightness. value between -127 and 127 (default: null)<br>
 *  <pre>$handle->image_brightness = 40;</pre></li>
 *  <li><b>{@link image_contrast}</b> if set, corrects the contrast. value between -127 and 127 (default: null)<br>
 *  <pre>$handle->image_contrast = 50;</pre></li>
 *  <li><b>{@link image_opacity}</b> if set, changes the image opacity. value between 0 and 100 (default: null)<br>
 *  <pre>$handle->image_opacity = 50;</pre></li>
 *  <li><b>{@link image_tint_color}</b> if set, will tint the image with a color, value as hexadecimal #FFFFFF (default: null)<br>
 *  <pre>$handle->image_tint_color = '#FF0000';</pre></li>
 *  <li><b>{@link image_overlay_color}</b> if set, will add a colored overlay, value as hexadecimal #FFFFFF (default: null)<br>
 *  <pre>$handle->image_overlay_color = '#FF0000';</pre></li>
 *  <li><b>{@link image_overlay_opacity}</b> used when {@link image_overlay_color} is set, determines the opacity (default: 50)<br>
 *  <pre>$handle->image_overlay_opacity = 20;</pre></li>
 *  <li><b>{@link image_negative}</b> inverts the colors in the image (default: false)<br>
 *  <pre>$handle->image_negative = true;</pre></li>
 *  <li><b>{@link image_greyscale}</b> transforms an image into greyscale (default: false)<br>
 *  <pre>$handle->image_greyscale = true;</pre></li>
 *  <li><b>{@link image_threshold}</b> applies a threshold filter. value between -127 and 127 (default: null)<br>
 *  <pre>$handle->image_threshold = 20;</pre></li>
 *  <li><b>{@link image_unsharp}</b> applies an unsharp mask, with alpha transparency support (default: false)<br>
 *  <pre>$handle->image_unsharp = true;</pre></li>
 *  <li><b>{@link image_unsharp_amount}</b> unsharp mask amount, typically 50 - 200 (default: 80)<br>
 *  <pre>$handle->image_unsharp_amount = 120;</pre></li>
 *  <li><b>{@link image_unsharp_radius}</b> unsharp mask radius, typically 0.5 - 1 (default: 0.5)<br>
 *  <pre>$handle->image_unsharp_radius = 0.8;</pre></li>
 *  <li><b>{@link image_unsharp_threshold}</b> unsharp mask threshold, typically 0 - 5 (default: 1)<br>
 *  <pre>$handle->image_unsharp_threshold = 0;</pre></li>
 * </ul>
 * <ul>
 *  <li><b>{@link image_text}</b> creates a text label on the image, value is a string, with eventual replacement tokens (default: null)<br>
 *  <pre>$handle->image_text = 'test';</pre></li>
 *  <li><b>{@link image_text_direction}</b> text label direction, either 'h' horizontal or 'v' vertical (default: 'h')<br>
 *  <pre>$handle->image_text_direction = 'v';</pre></li>
 *  <li><b>{@link image_text_color}</b> text color for the text label, in hexadecimal (default: #FFFFFF)<br>
 *  <pre>$handle->image_text_color = '#FF0000';</pre></li>
 *  <li><b>{@link image_text_opacity}</b> text opacity on the text label, integer between 0 and 100 (default: 100)<br>
 *  <pre>$handle->image_text_opacity = 50;</pre></li>
 *  <li><b>{@link image_text_background}</b> text label background color, in hexadecimal (default: null)<br>
 *  <pre>$handle->image_text_background = '#FFFFFF';</pre></li>
 *  <li><b>{@link image_text_background_opacity}</b> text label background opacity, integer between 0 and 100 (default: 100)<br>
 *  <pre>$handle->image_text_background_opacity = 50;</pre></li>
 *  <li><b>{@link image_text_font}</b> built-in font for the text label, from 1 to 5. 1 is the smallest (default: 5)<br>
 *  <pre>$handle->image_text_font = 4;</pre></li>
 *  <li><b>{@link image_text_x}</b> absolute text label position, in pixels from the left border. can be negative (default: null)<br>
 *  <pre>$handle->image_text_x = 5;</pre></li>
 *  <li><b>{@link image_text_y}</b> absolute text label position, in pixels from the top border. can be negative (default: null)<br>
 *  <pre>$handle->image_text_y = 5;</pre></li>
 *  <li><b>{@link image_text_position}</b> text label position withing the image, a combination of one or two from 'TBLR': top, bottom, left, right (default: null)<br>
 *  <pre>$handle->image_text_position = 'LR';</pre></li>
 *  <li><b>{@link image_text_padding}</b> text label padding, in pixels. can be overridden by {@link image_text_padding_x} and {@link image_text_padding_y} (default: 0)<br>
 *  <pre>$handle->image_text_padding = 5;</pre></li>
 *  <li><b>{@link image_text_padding_x}</b> text label horizontal padding (default: null)<br>
 *  <pre>$handle->image_text_padding_x = 2;</pre></li>
 *  <li><b>{@link image_text_padding_y}</b> text label vertical padding (default: null)<br>
 *  <pre>$handle->image_text_padding_y = 10;</pre></li>
 *  <li><b>{@link image_text_alignment}</b> text alignment when text has multiple lines, either 'L', 'C' or 'R' (default: 'C')<br>
 *  <pre>$handle->image_text_alignment = 'R';</pre></li>
 *  <li><b>{@link image_text_line_spacing}</b> space between lines in pixels, when text has multiple lines (default: 0)<br>
 *  <pre>$handle->image_text_line_spacing = 3;</pre></li>
 * </ul>
 * <ul>
 *  <li><b>{@link image_flip}</b> flips image, wither 'h' horizontal or 'v' vertical (default: null)<br>
 *  <pre>$handle->image_flip = 'h';</pre></li>
 *  <li><b>{@link image_rotate}</b> rotates image. possible values are 90, 180 and 270 (default: null)<br>
 *  <pre>$handle->image_rotate = 90;</pre></li>
 *  <li><b>{@link image_crop}</b> crops image. accepts 4, 2 or 1 values as 'T R B L' or 'TB LR' or 'TBLR'. dimension can be 20, or 20px or 20% (default: null)<br>
 *  <pre>$handle->image_crop = array(50,40,30,20); OR '-20 20%'...</pre></li>
 *  <li><b>{@link image_precrop}</b> crops image, before an eventual resizing. accepts 4, 2 or 1 values as 'T R B L' or 'TB LR' or 'TBLR'. dimension can be 20, or 20px or 20% (default: null)<br>
 *  <pre>$handle->image_precrop = array(50,40,30,20); OR '-20 20%'...</pre></li>
 * </ul>
 * <ul>
 *  <li><b>{@link image_bevel}</b> adds a bevel border to the image. value is thickness in pixels (default: null)<br>
 *  <pre>$handle->image_bevel = 20;</pre></li>
 *  <li><b>{@link image_bevel_color1}</b> top and left bevel color, in hexadecimal (default: #FFFFFF)<br>
 *  <pre>$handle->image_bevel_color1 = '#FFFFFF';</pre></li>
 *  <li><b>{@link image_bevel_color2}</b> bottom and right bevel color, in hexadecimal (default: #000000)<br>
 *  <pre>$handle->image_bevel_color2 = '#000000';</pre></li>
 *  <li><b>{@link image_border}</b> adds a unicolor border to the image. accepts 4, 2 or 1 values as 'T R B L' or 'TB LR' or 'TBLR'. dimension can be 20, or 20px or 20% (default: null)<br>
 *  <pre>$handle->image_border = '3px'; OR '-20 20%' OR array(3,2)...</pre></li>
 *  <li><b>{@link image_border_color}</b> border color, in hexadecimal (default: #FFFFFF)<br>
 *  <pre>$handle->image_border_color = '#FFFFFF';</pre></li>
 *  <li><b>{@link image_border_opacity}</b> border opacity, integer between 0 and 100 (default: 100)<br>
 *  <pre>$handle->image_border_opacity = 50;</pre></li>
 *  <li><b>{@link image_border_transparent}</b> adds a fading-to-transparent border to the image. accepts 4, 2 or 1 values as 'T R B L' or 'TB LR' or 'TBLR'. dimension can be 20, or 20px or 20% (default: null)<br>
 *  <pre>$handle->image_border_transparent = '3px'; OR '-20 20%' OR array(3,2)...</pre></li>
 *  <li><b>{@link image_frame}</b> type of frame: 1=flat 2=crossed (default: null)<br>
 *  <pre>$handle->image_frame = 2;</pre></li>
 *  <li><b>{@link image_frame_colors}</b> list of hex colors, in an array or a space separated string (default: '#FFFFFF #999999 #666666 #000000')<br>
 *  <pre>$handle->image_frame_colors = array('#999999',  '#FF0000', '#666666', '#333333', '#000000');</pre></li>
 *  <li><b>{@link image_frame_opacity}</b> frame opacity, integer between 0 and 100 (default: 100)<br>
 *  <pre>$handle->image_frame_opacity = 50;</pre></li>
 * </ul>
 * <ul>
 *  <li><b>{@link image_watermark}</b> adds a watermark on the image, value is a local filename. accepted files are GIF, JPG, BMP, PNG and PNG alpha (default: null)<br>
 *  <pre>$handle->image_watermark = 'watermark.png';</pre></li>
 *  <li><b>{@link image_watermark_x}</b> absolute watermark position, in pixels from the left border. can be negative (default: null)<br>
 *  <pre>$handle->image_watermark_x = 5;</pre></li>
 *  <li><b>{@link image_watermark_y}</b> absolute watermark position, in pixels from the top border. can be negative (default: null)<br>
 *  <pre>$handle->image_watermark_y = 5;</pre></li>
 *  <li><b>{@link image_watermark_position}</b> watermark position withing the image, a combination of one or two from 'TBLR': top, bottom, left, right (default: null)<br>
 *  <pre>$handle->image_watermark_position = 'LR';</pre></li>
 *  <li><b>{@link image_watermark_no_zoom_in}</b> prevents the watermark to be resized up if it is smaller than the image (default: true)<br>
 *  <pre>$handle->image_watermark_no_zoom_in = false;</pre></li>
 *  <li><b>{@link image_watermark_no_zoom_out}</b> prevents the watermark to be resized down if it is bigger than the image (default: false)<br>
 *  <pre>$handle->image_watermark_no_zoom_out = true;</pre></li>
 * </ul>
 * <ul>
 *  <li><b>{@link image_reflection_height}</b> if set, a reflection will be added. Format is either in pixels or percentage, such as 40, '40', '40px' or '40%' (default: null)<br>
 *  <pre>$handle->image_reflection_height = '25%';</pre></li>
 *  <li><b>{@link image_reflection_space}</b> space in pixels between the source image and the reflection, can be negative (default: null)<br>
 *  <pre>$handle->image_reflection_space = 3;</pre></li>
 *  <li><b>{@link image_reflection_color}</b> reflection background color, in hexadecimal. Now deprecated in favor of {@link image_default_color} (default: #FFFFFF)<br>
 *  <pre>$handle->image_default_color = '#000000';</pre></li>
 *  <li><b>{@link image_reflection_opacity}</b> opacity level at which the reflection starts, integer between 0 and 100 (default: 60)<br>
 *  <pre>$handle->image_reflection_opacity = 60;</pre></li>
 * </ul>
 *
 * <b>Values that can be read before calling {@link process}()</b>
 * <ul>
 *  <li><b>{@link file_src_name}</b> Source file name</li>
 *  <li><b>{@link file_src_name_body}</b> Source file name body</li>
 *  <li><b>{@link file_src_name_ext}</b> Source file extension</li>
 *  <li><b>{@link file_src_pathname}</b> Source file complete path and name</li>
 *  <li><b>{@link file_src_mime}</b> Source file mime type</li>
 *  <li><b>{@link file_src_size}</b> Source file size in bytes</li>
 *  <li><b>{@link file_src_error}</b> Upload error code</li>
 *  <li><b>{@link file_is_image}</b> Boolean flag, true if the file is a supported image type</li>
 * </ul>
 * If the file is a supported image type (and <i>open_basedir</i> restrictions allow it)
 * <ul>
 *  <li><b>{@link image_src_x}</b> Source file width in pixels</li>
 *  <li><b>{@link image_src_y}</b> Source file height in pixels</li>
 *  <li><b>{@link image_src_pixels}</b> Source file number of pixels</li>
 *  <li><b>{@link image_src_type}</b> Source file type (png, jpg, gif or bmp)</li>
 *  <li><b>{@link image_src_bits}</b> Source file color depth</li>
 * </ul>
 *
 * <b>Values that can be read after calling {@link process}()</b>
 * <ul>
 *  <li><b>{@link file_dst_path}</b> Destination file path</li>
 *  <li><b>{@link file_dst_name_body}</b> Destination file name body</li>
 *  <li><b>{@link file_dst_name_ext}</b> Destination file extension</li>
 *  <li><b>{@link file_dst_name}</b> Destination file name</li>
 *  <li><b>{@link file_dst_pathname}</b> Destination file complete path and name</li>
 * </ul>
 * If the file is a supported image type
 * <ul>
 *  <li><b>{@link image_dst_x}</b> Destination file width</li>
 *  <li><b>{@link image_dst_y}</b> Destination file height</li>
 *  <li><b>{@link image_convert}</b> Destination file format</li>
 * </ul>
 *
 * <b>Requirements</b>
 *
 * Most of the image operations require GD. GD2 is greatly recommended
 *
 * The class is compatible with PHP 4.3+, and compatible with PHP5
 *
 * <b>Changelog</b>
 * <ul>
 *  <li><b>v 0.31</b> 11/04/2011<br>
 *   - added application/x-rar MIME type<br>
 *   - make sure exec() and ini_get_all()function are not disabled if we want to use them<br>
 *   - make sure that we don't divide by zero when calculating JPEG size<br>
 *   - {@link allowed} and {@link forbidden} can now accept strings<br>
 *   - try to guess the file extension from the MIME type if there is no file extension<br>
 *   - better class properties when changing the file extension<br>
 *   - added {@link file_force_extension} to allow extension-less files if needed<br>
 *   - better file safe conversion of the filename<br>
 *   - allow shorthand byte values, such as 1K, 2M, 3G for {@link file_max_size} and {@link jpeg_size}<br>
 *   - added {@link image_opacity} to change picture opacity<br>
 *   - added {@link image_border_opacity} to allow semi-transparent borders<br>
 *   - added {@link image_frame_opacity} to allow semi-transparent frames<br>
 *   - added {@link image_border_transparent} to allow borders fading to transparent<br>
 *   - duplicated {@link image_overlay_percent} into {@link image_overlay_opacity}<br>
 *   - duplicated {@link image_text_percent} into {@link image_text_opacity}<br>
 *   - duplicated {@link image_text_background_percent} into {@link image_text_background_opacity}</li>
 *  <li><b>v 0.30</b> 05/09/2010<br>
 *   - implemented an unsharp mask, with alpha transparency support, activated if {@link image_unsharp} is true. added {@link image_unsharp_amount}, {@link image_unsharp_radius}, and {@link image_unsharp_threshold}<br>
 *   - added text/rtf MIME type, and no_script exception<br>
 *   - corrected bug when {@link no_script} is activated and several process() are called<br>
 *   - better error handling for finfo<br>
 *   - display upload_max_filesize information from php.ini in the log<br>
 *   - automatic extension for extension-less images<br>
 *   - fixed {@link image_ratio_fill} top and left filling<br>
 *   - fixed alphablending issue when applying a transparent PNG watermark on a transparent PNG<br>
 *   - added {@link image_watermark_no_zoom_in} and {@link image_watermark_no_zoom_out} to allow the watermark to be resized down (or up) to fit in the image. By default, the watermark may be resized down, but not up.</li>
 *  <li><b>v 0.29</b> 03/02/2010<br>
 *   - added protection against malicious images<br>
 *   - added zip and torrent MIME type<br>
 *   - replaced split() with explode()<br>
 *   - initialise image_dst_x/y with image_src_x/y<br>
 *   - removed {@link mime_fileinfo}, {@link mime_file}, {@link mime_magic} and {@link mime_getimagesize} from the docs since they are used before {@link process}<br>
 *   - added more extensions and MIME types<br>
 *   - improved MIME type validation<br>
 *   - improved logging</li>
 *  <li><b>v 0.28</b> 10/08/2009<br>
 *   - replaced ereg functions to be compatible with PHP 5.3<br>
 *   - added flv MIME type<br>
 *   - improved MIME type detection<br>
 *   - added {@link file_name_body_pre} to prepend a string to the file name<br>
 *   - added {@link mime_fileinfo}, {@link mime_file}, {@link mime_magic} and {@link mime_getimagesize} so that it is possible to deactivate some MIME type checking method<br>
 *   - use exec() rather than shell_exec(), to play better with safe mode <br>
 *   - added some error messages<br>
 *   - fix bug when checking on conditions, {@link processed} wasn't propagated properly</li>
 *  <li><b>v 0.27</b> 14/05/2009<br>
 *   - look for the language files directory from __FILE__<br>
 *   - deactivate {@link file_auto_rename} if {@link file_overwrite} is set<br>
 *   - improved transparency replacement for true color images<br>
 *   - fixed calls to newer version of UNIX file utility<br>
 *   - fixed error when using PECL Fileinfo extension in SAFE MODE, and when using the finfo class<br>
 *   - added {@link image_precrop} to crop the image before an eventual resizing</li>
 *  <li><b>v 0.26</b> 13/11/2008<br>
 *   - rewrote conversion from palette to true color to handle transparency better<br>
 *   - fixed imagecopymergealpha() when the overlayed image is of wrong dimensions<br>
 *   - fixed imagecreatenew() when the image to create have less than 1 pixels width or height<br>
 *   - rewrote MIME type detection to be more secure and not rely on browser information; now using Fileinfo PECL extension, UNIX file() command, MIME magic, and getimagesize(), in that order<br>
 *   - added support for Flash uploaders<br>
 *   - some bug fixing and error handling</li>
 *  <li><b>v 0.25</b> 17/11/2007<br>
 *   - added translation files and mechanism to instantiate the class with a language different from English<br>
 *   - added {@link forbidden} to set an array of forbidden MIME types<br>
 *   - implemented support for simple wildcards in {@link allowed} and {@link forbidden}, such as image/*<br>
 *   - preset the file extension to the desired conversion format when converting an image<br>
 *   - added read and write support for BMP images<br>
 *   - added a flag {@link file_is_image} to determine if the file is a supported image type<br>
 *   - the class now provides some information about the image, before calling {@link process}(). Available are {@link image_src_x}, {@link image_src_y} and the newly introduced {@link image_src_bits}, {@link image_src_pixels} and {@link image_src_type}. Note that this will not work if <i>open_basedir</i> restrictions are in place<br>
 *   - improved logging; now provides useful system information<br>
 *   - added some more pre-processing checks for files that are images: {@link image_max_width}, {@link image_max_height}, {@link image_max_pixels}, {@link image_max_ratio}, {@link image_min_width}, {@link image_min_height}, {@link image_min_pixels} and {@link image_min_ratio}<br>
 *   - added {@link image_ratio_pixels} to resize an image to a number of pixels, keeping aspect ratio<br>
 *   - added {@link image_is_palette} and {@link image_is_transparent} and {@link image_transparent_color} for GIF images<br>
 *   - added {@link image_default_color} to define a fallback color for non alpha-transparent output formats, such as JPEG or BMP<br>
 *   - changed {@link image_background_color}, which now forces transparent areas to be painted<br>
 *   - improved reflections and color overlays so that it works with alpha transparent images<br>
 *   - {@link image_reflection_color} is now deprecated in favour of {@link image_default_color}<br />
 *   - transparent PNGs are now processed in true color, and fully preserving the alpha channel when doing merges<br>
 *   - transparent GIFs are now automatically detected. {@link preserve_transparency} is deprecated<br>
 *   - transparent true color images can be saved as GIF while retaining transparency, semi transparent areas being merged with {@link image_default_color}<br>
 *   - transparent true color images can be saved as JPG/BMP with the semi transparent areas being merged with {@link image_default_color}<br>
 *   - fixed conversion of images to true color<br>
 *   - the class can now output the uploaded files content as the return value of process() if the function is called with an empty or null argumenti, or no argument</li>
 *  <li><b>v 0.24</b> 25/05/2007<br>
 *   - added {@link image_background_color}, to set the default background color of an image<br>
 *   - added possibility of using replacement tokens in text labels<br>
 *   - changed default JPEG quality to 85<br>
 *   - fixed a small bug when using greyscale filter and associated filters<br>
 *   - added {@link image_ratio_fill} in order to fit an image within some dimensions and color the remaining space. Very similar to {@link image_ratio_crop}<br>
 *   - improved the recursive creation of directories<br>
 *   - the class now converts palette based images to true colors before doing graphic manipulations</li>
 *  <li><b>v 0.23</b> 23/12/2006<br>
 *   - fixed a bug when processing more than once the same uploaded file. If there is an open_basedir restriction, the class now creates a temporary file for the first call to process(). This file will be used for subsequent processes, and will be deleted upon calling clean()</li>
 *  <li><b>v 0.22</b> 16/12/2006<br>
 *   - added automatic creation of a temporary file if the upload directory is not within open_basedir<br>
 *   - fixed a bug which was preventing to work on a local file by overwriting it with its processed copy<br>
 *   - added MIME types video/x-ms-wmv and image/x-png and fixed PNG support for IE weird MIME types<br>
 *   - modified {@link image_ratio_crop} so it can accept one or more from string 'TBLR', determining which side of the image is kept while cropping<br>
 *   - added support for multiple lines in the text, using "\n" as a line break<br>
 *   - added {@link image_text_line_spacing} which allow to set the space between several lines of text<br>
 *   - added {@link image_text_alignment} which allow to set the alignment when text has several lines<br>
 *   - {@link image_text_font} can now be set to the path of a GDF font to load external fonts<br>
 *   - added {@link image_reflection_height} to create a reflection of the source image, which height is in pixels or percentage<br>
 *   - added {@link image_reflection_space} to set the space in pixels between the source image and the reflection<br>
 *   - added {@link image_reflection_color} to set the reflection background color<br>
 *   - added {@link image_reflection_opacity} to set the initial level of opacity of the reflection</li>
 *  <li><b>v 0.21</b> 30/09/2006<br>
 *   - added {@link image_ratio_crop} which resizes within {@link image_x} and {@link image_y}, keeping ratio, but filling the space by cropping excedent of image<br>
 *   - added {@link mime_check}, which default is true, to set checks against {@link allowed} MIME list<br>
 *   - if MIME is empty, the class now triggers an error<br>
 *   - color #000000 is OK for {@link image_text_color}, and related text transparency bug fixed<br>
 *   - {@link gd_version}() now uses gd_info(), or else phpinfo()<br>
 *   - fixed path issue when the destination path has no trailing slash on Windows systems <br>
 *   - removed inline functions to be fully PHP5 compatible </li>
 *  <li><b>v 0.20</b> 11/08/2006<br>
 *   - added some more error checking and messages (GD presence, permissions...)<br>
 *   - fix when uploading files without extension<br>
 *   - changed values for {@link image_brightness} and {@link image_contrast} to be between -127 and 127<br>
 *   - added {@link dir_auto_create} to automatically and recursively create destination directory if missing.<br>
 *   - added {@link dir_auto_chmod} to automatically chmod the destination directory if not writeable.<br>
 *   - added {@link dir_chmod} to set the default chmod to use.<br>
 *   - added {@link image_crop} to crop images<br>
 *   - added {@link image_negative} to invert the colors on the image<br>
 *   - added {@link image_greyscale} to turn the image into greyscale<br>
 *   - added {@link image_threshold} to apply a threshold filter on the image<br>
 *   - added {@link image_bevel}, {@link image_bevel_color1} and {@link image_bevel_color2} to add a bevel border<br>
 *   - added {@link image_border} and {@link image_border_color} to add a single color border<br>
 *   - added {@link image_frame} and {@link image_frame_colors} to add a multicolored frame</li>
 *  <li><b>v 0.19</b> 29/03/2006<br>
 *   - class is now compatible i18n (thanks Sylwester).<br>
 *   - the class can mow manipulate local files, not only uploaded files (instanciate the class with a local filename).<br>
 *   - {@link file_safe_name} has been improved a bit.<br>
 *   - added {@link image_brightness}, {@link image_contrast}, {@link image_tint_color}, {@link image_overlay_color} and {@link image_overlay_percent} to do color manipulation on the images.<br>
 *   - added {@link image_text} and all derivated settings to add a text label on the image.<br>
 *   - added {@link image_watermark} and all derivated settings to add a watermark image on the image.<br>
 *   - added {@link image_flip} and {@link image_rotate} for more image manipulations<br>
 *   - added {@link jpeg_size} to calculate the JPG compression quality in order to fit within one filesize.</li>
 *  <li><b>v 0.18</b> 02/02/2006<br>
 *   - added {@link no_script} to turn dangerous scripts into text files.<br>
 *   - added {@link mime_magic_check} to set the class to use mime_magic.<br>
 *   - added {@link preserve_transparency} *experimental*. Thanks Gregor.<br>
 *   - fixed size and mime checking, wasn't working :/ Thanks Willem.<br>
 *   - fixed memory leak when resizing images.<br>
 *   - when resizing, it is not necessary anymore to set {@link image_convert}.<br>
 *   - il is now possible to simply convert an image, with no resizing.<br>
 *   - sets the default {@link file_max_size} to upload_max_filesize from php.ini. Thanks Edward</li>
 *  <li><b>v 0.17</b> 28/05/2005<br>
 *   - the class can be used with any version of GD.<br>
 *   - added security check on the file with a list of mime-types.<br>
 *   - changed the license to GPL v2 only</li>
 *  <li><b>v 0.16</b> 19/05/2005<br>
 *   - added {@link file_auto_rename} automatic file renaming if the same filename already exists.<br>
 *   - added {@link file_safe_name} safe formatting of the filename (spaces to _underscores so far).<br>
 *   - added some more error reporting to avoid crash if GD is not present</li>
 *  <li><b>v 0.15</b> 16/04/2005<br>
 *   - added JPEG compression quality setting. Thanks Vad</li>
 *  <li><b>v 0.14</b> 14/03/2005<br>
 *   - reworked the class file to allow parsing with phpDocumentor</li>
 *  <li><b>v 0.13</b> 07/03/2005<br>
 *   - fixed a bug with {@link image_ratio}. Thanks Justin.<br>
 *   - added {@link image_ratio_no_zoom_in} and {@link image_ratio_no_zoom_out} </li>
 *  <li><b>v 0.12</b> 21/01/2005<br>
 *   - added {@link image_ratio} to resize within max values, keeping image ratio</li>
 *  <li><b>v 0.11</b> 22/08/2003<br>
 *   - update for GD2 (changed imageresized() into imagecopyresampled() and imagecreate() into imagecreatetruecolor())</li>
 * </ul>
 *
 * @package   cmf
 * @subpackage external
 */
class upload {


    /**
     * Class version
     *
     * @access public
     * @var string
     */
    var $version;

    /**
     * Uploaded file name
     *
     * @access public
     * @var string
     */
    var $file_src_name;

    /**
     * Uploaded file name body (i.e. without extension)
     *
     * @access public
     * @var string
     */
    var $file_src_name_body;

    /**
     * Uploaded file name extension
     *
     * @access public
     * @var string
     */
    var $file_src_name_ext;

    /**
     * Uploaded file MIME type
     *
     * @access public
     * @var string
     */
    var $file_src_mime;

    /**
     * Uploaded file size, in bytes
     *
     * @access public
     * @var double
     */
    var $file_src_size;

    /**
     * Holds eventual PHP error code from $_FILES
     *
     * @access public
     * @var string
     */
    var $file_src_error;

    /**
     * Uloaded file name, including server path
     *
     * @access public
     * @var string
     */
    var $file_src_pathname;

    /**
     * Uloaded file name temporary copy
     *
     * @access private
     * @var string
     */
    var $file_src_temp;

    /**
     * Destination file name
     *
     * @access public
     * @var string
     */
    var $file_dst_path;

    /**
     * Destination file name
     *
     * @access public
     * @var string
     */
    var $file_dst_name;

    /**
     * Destination file name body (i.e. without extension)
     *
     * @access public
     * @var string
     */
    var $file_dst_name_body;

    /**
     * Destination file extension
     *
     * @access public
     * @var string
     */
    var $file_dst_name_ext;

    /**
     * Destination file name, including path
     *
     * @access public
     * @var string
     */
    var $file_dst_pathname;

    /**
     * Source image width
     *
     * @access public
     * @var integer
     */
    var $image_src_x;

    /**
     * Source image height
     *
     * @access public
     * @var integer
     */
    var $image_src_y;

    /**
     * Source image color depth
     *
     * @access public
     * @var integer
     */
    var $image_src_bits;

    /**
     * Number of pixels
     *
     * @access public
     * @var long
     */
    var $image_src_pixels;

    /**
     * Type of image (png, gif, jpg or bmp)
     *
     * @access public
     * @var string
     */
    var $image_src_type;

    /**
     * Destination image width
     *
     * @access public
     * @var integer
     */
    var $image_dst_x;

    /**
     * Destination image height
     *
     * @access public
     * @var integer
     */
    var $image_dst_y;

    /**
     * Supported image formats
     *
     * @access private
     * @var array
     */
    var $image_supported;

    /**
     * Flag to determine if the source file is an image
     *
     * @access public
     * @var boolean
     */
    var $file_is_image;

    /**
     * Flag set after instanciating the class
     *
     * Indicates if the file has been uploaded properly
     *
     * @access public
     * @var bool
     */
    var $uploaded;

    /**
     * Flag stopping PHP upload checks
     *
     * Indicates whether we instanciated the class with a filename, in which case
     * we will not check on the validity of the PHP *upload*
     *
     * This flag is automatically set to true when working on a local file
     *
     * Warning: for uploads, this flag MUST be set to false for security reason
     *
     * @access public
     * @var bool
     */
    var $no_upload_check;

    /**
     * Flag set after calling a process
     *
     * Indicates if the processing, and copy of the resulting file went OK
     *
     * @access public
     * @var bool
     */
    var $processed;

    /**
     * Holds eventual error message in plain english
     *
     * @access public
     * @var string
     */
    var $error;

    /**
     * Holds an HTML formatted log
     *
     * @access public
     * @var string
     */
    var $log;


    // overiddable processing variables


    /**
     * Set this variable to replace the name body (i.e. without extension)
     *
     * @access public
     * @var string
     */
    var $file_new_name_body;

    /**
     * Set this variable to append a string to the file name body
     *
     * @access public
     * @var string
     */
    var $file_name_body_add;

    /**
     * Set this variable to prepend a string to the file name body
     *
     * @access public
     * @var string
     */
    var $file_name_body_pre;

    /**
     * Set this variable to change the file extension
     *
     * @access public
     * @var string
     */
    var $file_new_name_ext;

    /**
     * Set this variable to format the filename (spaces changed to _)
     *
     * @access public
     * @var boolean
     */
    var $file_safe_name;

    /**
     * Forces an extension if the source file doesn't have one
     *
     * If the file is an image, then the correct extension will be added
     * Otherwise, a .txt extension will be chosen
     *
     * @access public
     * @var boolean
     */
    var $file_force_extension;

    /**
     * Set this variable to false if you don't want to check the MIME against the allowed list
     *
     * This variable is set to true by default for security reason
     *
     * @access public
     * @var boolean
     */
    var $mime_check;

    /**
     * Set this variable to false in the init() function if you don't want to check the MIME 
     * with Fileinfo PECL extension. On some systems, Fileinfo is known to be buggy, and you
     * may want to deactivate it in the class code directly.
     *
     * You can also set it with the path of the magic database file.
     * If set to true, the class will try to read the MAGIC environment variable
     *   and if it is empty, will default to '/usr/share/file/magic'
     * If set to an empty string, it will call finfo_open without the path argument
     *
     * This variable is set to true by default for security reason
     *
     * @access public
     * @var boolean
     */
    var $mime_fileinfo;

    /**
     * Set this variable to false in the init() function if you don't want to check the MIME 
     * with UNIX file() command
     *
     * This variable is set to true by default for security reason
     *
     * @access public
     * @var boolean
     */
    var $mime_file;

    /**
     * Set this variable to false in the init() function if you don't want to check the MIME 
     * with the magic.mime file
     *
     * The function mime_content_type() will be deprecated,
     * and this variable will be set to false in a future release
     *
     * This variable is set to true by default for security reason
     *
     * @access public
     * @var boolean
     */
    var $mime_magic;

    /**
     * Set this variable to false in the init() function if you don't want to check the MIME 
     * with getimagesize()
     *
     * The class tries to get a MIME type from getimagesize()
     * If no MIME is returned, it tries to guess the MIME type from the file type
     *
     * This variable is set to true by default for security reason
     *
     * @access public
     * @var boolean
     */
    var $mime_getimagesize;

    /**
     * Set this variable to false if you don't want to turn dangerous scripts into simple text files
     *
     * @access public
     * @var boolean
     */
    var $no_script;

    /**
     * Set this variable to true to allow automatic renaming of the file
     * if the file already exists
     *
     * Default value is true
     *
     * For instance, on uploading foo.ext,<br>
     * if foo.ext already exists, upload will be renamed foo_1.ext<br>
     * and if foo_1.ext already exists, upload will be renamed foo_2.ext<br>
     *
     * Note that this option doesn't have any effect if {@link file_overwrite} is true
     *
     * @access public
     * @var bool
     */
    var $file_auto_rename;

    /**
     * Set this variable to true to allow automatic creation of the destination
     * directory if it is missing (works recursively)
     *
     * Default value is true
     *
     * @access public
     * @var bool
     */
    var $dir_auto_create;

    /**
     * Set this variable to true to allow automatic chmod of the destination
     * directory if it is not writeable
     *
     * Default value is true
     *
     * @access public
     * @var bool
     */
    var $dir_auto_chmod;

    /**
     * Set this variable to the default chmod you want the class to use
     * when creating directories, or attempting to write in a directory
     *
     * Default value is 0777 (without quotes)
     *
     * @access public
     * @var bool
     */
    var $dir_chmod;

    /**
     * Set this variable tu true to allow overwriting of an existing file
     *
     * Default value is false, so no files will be overwritten
     *
     * @access public
     * @var bool
     */
    var $file_overwrite;

    /**
     * Set this variable to change the maximum size in bytes for an uploaded file
     *
     * Default value is the value <i>upload_max_filesize</i> from php.ini
     *
     * Value in bytes (integer) or shorthand byte values (string) is allowed. 
     * The available options are K (for Kilobytes), M (for Megabytes) and G (for Gigabytes)
     *
     * @access public
     * @var double
     */
    var $file_max_size;

    /**
     * Set this variable to true to resize the file if it is an image
     *
     * You will probably want to set {@link image_x} and {@link image_y}, and maybe one of the ratio variables
     *
     * Default value is false (no resizing)
     *
     * @access public
     * @var bool
     */
    var $image_resize;

    /**
     * Set this variable to convert the file if it is an image
     *
     * Possibles values are : ''; 'png'; 'jpeg'; 'gif'; 'bmp'
     *
     * Default value is '' (no conversion)<br>
     * If {@link resize} is true, {@link convert} will be set to the source file extension
     *
     * @access public
     * @var string
     */
    var $image_convert;

    /**
     * Set this variable to the wanted (or maximum/minimum) width for the processed image, in pixels
     *
     * Default value is 150
     *
     * @access public
     * @var integer
     */
    var $image_x;

    /**
     * Set this variable to the wanted (or maximum/minimum) height for the processed image, in pixels
     *
     * Default value is 150
     *
     * @access public
     * @var integer
     */
    var $image_y;

    /**
     * Set this variable to keep the original size ratio to fit within {@link image_x} x {@link image_y}
     *
     * Default value is false
     *
     * @access public
     * @var bool
     */
    var $image_ratio;

    /**
     * Set this variable to keep the original size ratio to fit within {@link image_x} x {@link image_y}
     *
     * The image will be resized as to fill the whole space, and excedent will be cropped
     *
     * Value can also be a string, one or more character from 'TBLR' (top, bottom, left and right)
     * If set as a string, it determines which side of the image is kept while cropping.
     * By default, the part of the image kept is in the center, i.e. it crops equally on both sides
     *
     * Default value is false
     *
     * @access public
     * @var mixed
     */
    var $image_ratio_crop;

    /**
     * Set this variable to keep the original size ratio to fit within {@link image_x} x {@link image_y}
     *
     * The image will be resized to fit entirely in the space, and the rest will be colored.
     * The default color is white, but can be set with {@link image_default_color}
     *
     * Value can also be a string, one or more character from 'TBLR' (top, bottom, left and right)
     * If set as a string, it determines in which side of the space the image is displayed.
     * By default, the image is displayed in the center, i.e. it fills the remaining space equally on both sides
     *
     * Default value is false
     *
     * @access public
     * @var mixed
     */
    var $image_ratio_fill;

    /**
     * Set this variable to a number of pixels so that {@link image_x} and {@link image_y} are the best match possible
     *
     * The image will be resized to have approximatively the number of pixels
     * The aspect ratio wil be conserved
     *
     * Default value is false
     *
     * @access public
     * @var mixed
     */
    var $image_ratio_pixels;

    /**
     * Set this variable to keep the original size ratio to fit within {@link image_x} x {@link image_y},
     * but only if original image is bigger
     *
     * Default value is false
     *
     * @access public
     * @var bool
     */
    var $image_ratio_no_zoom_in;

    /**
     * Set this variable to keep the original size ratio to fit within {@link image_x} x {@link image_y},
     * but only if original image is smaller
     *
     * Default value is false
     *
     * @access public
     * @var bool
     */
    var $image_ratio_no_zoom_out;

    /**
     * Set this variable to calculate {@link image_x} automatically , using {@link image_y} and conserving ratio
     *
     * Default value is false
     *
     * @access public
     * @var bool
     */
    var $image_ratio_x;

    /**
     * Set this variable to calculate {@link image_y} automatically , using {@link image_x} and conserving ratio
     *
     * Default value is false
     *
     * @access public
     * @var bool
     */
    var $image_ratio_y;

    /**
     * Set this variable to set a maximum image width, above which the upload will be invalid
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_max_width;

    /**
     * Set this variable to set a maximum image height, above which the upload will be invalid
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_max_height;

    /**
     * Set this variable to set a maximum number of pixels for an image, above which the upload will be invalid
     *
     * Default value is null
     *
     * @access public
     * @var long
     */
    var $image_max_pixels;

    /**
     * Set this variable to set a maximum image aspect ratio, above which the upload will be invalid
     *
     * Note that ratio = width / height
     *
     * Default value is null
     *
     * @access public
     * @var float
     */
    var $image_max_ratio;

    /**
     * Set this variable to set a minimum image width, below which the upload will be invalid
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_min_width;

    /**
     * Set this variable to set a minimum image height, below which the upload will be invalid
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_min_height;

    /**
     * Set this variable to set a minimum number of pixels for an image, below which the upload will be invalid
     *
     * Default value is null
     *
     * @access public
     * @var long
     */
    var $image_min_pixels;

    /**
     * Set this variable to set a minimum image aspect ratio, below which the upload will be invalid
     *
     * Note that ratio = width / height
     *
     * Default value is null
     *
     * @access public
     * @var float
     */
    var $image_min_ratio;

    /**
     * Quality of JPEG created/converted destination image
     *
     * Default value is 85
     *
     * @access public
     * @var integer
     */
    var $jpeg_quality;

    /**
     * Determines the quality of the JPG image to fit a desired file size
     *
     * The JPG quality will be set between 1 and 100%
     * The calculations are approximations.
     *
     * Value in bytes (integer) or shorthand byte values (string) is allowed. 
     * The available options are K (for Kilobytes), M (for Megabytes) and G (for Gigabytes)
     *
     * Default value is null (no calculations)
     *
     * @access public
     * @var integer
     */
    var $jpeg_size;

    /**
     * Preserve transparency when resizing or converting an image (deprecated)
     *
     * Default value is automatically set to true for transparent GIFs
     * This setting is now deprecated
     *
     * @access public
     * @var integer
     */
    var $preserve_transparency;

    /**
     * Flag set to true when the image is transparent
     *
     * This is actually used only for transparent GIFs
     *
     * @access public
     * @var boolean
     */
    var $image_is_transparent;

    /**
     * Transparent color in a palette
     *
     * This is actually used only for transparent GIFs
     *
     * @access public
     * @var boolean
     */
    var $image_transparent_color;

    /**
     * Background color, used to paint transparent areas with
     *
     * If set, it will forcibly remove transparency by painting transparent areas with the color
     * This setting will fill in all transparent areas in PNG and GIF, as opposed to {@link image_default_color}
     * which will do so only in BMP, JPEG, and alpha transparent areas in transparent GIFs
     * This setting overrides {@link image_default_color}
     *
     * Default value is null
     *
     * @access public
     * @var string
     */
    var $image_background_color;

    /**
     * Default color for non alpha-transparent images
     *
     * This setting is to be used to define a background color for semi transparent areas
     * of an alpha transparent when the output format doesn't support alpha transparency
     * This is useful when, from an alpha transparent PNG image, or an image with alpha transparent features
     * if you want to output it as a transparent GIFs for instance, you can set a blending color for transparent areas
     * If you output in JPEG or BMP, this color will be used to fill in the previously transparent areas
     *
     * The default color white
     *
     * @access public
     * @var boolean
     */
    var $image_default_color;

    /**
     * Flag set to true when the image is not true color
     *
     * @access public
     * @var boolean
     */
    var $image_is_palette;

    /**
     * Corrects the image brightness
     *
     * Value can range between -127 and 127
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_brightness;

    /**
     * Corrects the image contrast
     *
     * Value can range between -127 and 127
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_contrast;

    /**
     * Changes the image opacity
     *
     * Value can range between 0 and 100
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_opacity;

    /**
     * Applies threshold filter
     *
     * Value can range between -127 and 127
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */
    var $image_threshold;

    /**
     * Applies a tint on the image
     *
     * Value is an hexadecimal color, such as #FFFFFF
     *
     * Default value is null
     *
     * @access public
     * @var string;
     */
    var $image_tint_color;

    /**
     * Applies a colored overlay on the image
     *
     * Value is an hexadecimal color, such as #FFFFFF
     *
     * To use with {@link image_overlay_opacity}
     *
     * Default value is null
     *
     * @access public
     * @var string;
     */
    var $image_overlay_color;

    /**
     * Sets the opacity for the colored overlay
     *
     * Value is a percentage, as an integer between 0 (transparent) and 100 (opaque)
     *
     * Unless used with {@link image_overlay_color}, this setting has no effect
     *
     * Default value is 50
     *
     * @access public
     * @var integer
     */
    var $image_overlay_opacity;

    /**
     * Soon to be deprecated old form of {@link image_overlay_opacity}
     *
     * @access public
     * @var integer
     */
    var $image_overlay_percent;

    /**
     * Inverts the color of an image
     *
     * Default value is FALSE
     *
     * @access public
     * @var boolean;
     */
    var $image_negative;

    /**
     * Turns the image into greyscale
     *
     * Default value is FALSE
     *
     * @access public
     * @var boolean;
     */
    var $image_greyscale;

    /**
     * Applies an unsharp mask, with alpha transparency support
     *
     * Beware that this unsharp mask is quite resource-intensive
     *
     * Default value is FALSE
     *
     * @access public
     * @var boolean;
     */
    var $image_unsharp;

    /**
     * Sets the unsharp mask amount
     *
     * Value is an integer between 0 and 500, typically between 50 and 200
     *
     * Unless used with {@link image_unsharp}, this setting has no effect
     *
     * Default value is 80
     *
     * @access public
     * @var integer
     */
    var $image_unsharp_amount;
 
    /**
     * Sets the unsharp mask radius
     *
     * Value is an integer between 0 and 50, typically between 0.5 and 1
     *
     * Unless used with {@link image_unsharp}, this setting has no effect
     *
     * Default value is 0.5
     *
     * @access public
     * @var integer
     */
    var $image_unsharp_radius;
 
    /**
     * Sets the unsharp mask threshold
     *
     * Value is an integer between 0 and 255, typically between 0 and 5
     *
     * Unless used with {@link image_unsharp}, this setting has no effect
     *
     * Default value is 1
     *
     * @access public
     * @var integer
     */
    var $image_unsharp_threshold;

    /**
     * Adds a text label on the image
     *
     * Value is a string, any text. Text will not word-wrap, although you can use breaklines in your text "\n"
     *
     * If set, this setting allow the use of all other settings starting with image_text_
     *
     * Replacement tokens can be used in the string:
     * <pre>
     * gd_version    src_name       src_name_body src_name_ext
     * src_pathname  src_mime       src_x         src_y
     * src_type      src_bits       src_pixels
     * src_size      src_size_kb    src_size_mb   src_size_human
     * dst_path      dst_name_body  dst_pathname
     * dst_name      dst_name_ext   dst_x         dst_y
     * date          time           host          server        ip
     * </pre>
     * The tokens must be enclosed in square brackets: [dst_x] will be replaced by the width of the picture
     *
     * Default value is null
     *
     * @access public
     * @var string;
     */
    var $image_text;

    /**
     * Sets the text direction for the text label
     *
     * Value is either 'h' or 'v', as in horizontal and vertical
     *
     * Default value is h (horizontal)
     *
     * @access public
     * @var string;
     */
    var $image_text_direction;

    /**
     * Sets the text color for the text label
     *
     * Value is an hexadecimal color, such as #FFFFFF
     *
     * Default value is #FFFFFF (white)
     *
     * @access public
     * @var string;
     */
    var $image_text_color;

    /**
     * Sets the text opacity in the text label
     *
     * Value is a percentage, as an integer between 0 (transparent) and 100 (opaque)
     *
     * Default value is 100
     *
     * @access public
     * @var integer
     */
    var $image_text_opacity;

    /**
     * Soon to be deprecated old form of {@link image_text_opacity}
     *
     * @access public
     * @var integer
     */
    var $image_text_percent;

    /**
     * Sets the text background color for the text label
     *
     * Value is an hexadecimal color, such as #FFFFFF
     *
     * Default value is null (no background)
     *
     * @access public
     * @var string;
     */
    var $image_text_background;

    /**
     * Sets the text background opacity in the text label
     *
     * Value is a percentage, as an integer between 0 (transparent) and 100 (opaque)
     *
     * Default value is 100
     *
     * @access public
     * @var integer
     */
    var $image_text_background_opacity;

    /**
     * Soon to be deprecated old form of {@link image_text_background_opacity}
     *
     * @access public
     * @var integer
     */
    var $image_text_background_percent;

    /**
     * Sets the text font in the text label
     *
     * Value is a an integer between 1 and 5 for GD built-in fonts. 1 is the smallest font, 5 the biggest
     * Value can also be a string, which represents the path to a GDF font. The font will be loaded into GD, and used as a built-in font.
     *
     * Default value is 5
     *
     * @access public
     * @var mixed;
     */
    var $image_text_font;

    /**
     * Sets the text label position within the image
     *
     * Value is one or two out of 'TBLR' (top, bottom, left, right)
     *
     * The positions are as following:
     * <pre>
     *                        TL  T  TR
     *                        L       R
     *                        BL  B  BR
     * </pre>
     *
     * Default value is null (centered, horizontal and vertical)
     *
     * Note that is {@link image_text_x} and {@link image_text_y} are used, this setting has no effect
     *
     * @access public
     * @var string;
     */
    var $image_text_position;

    /**
     * Sets the text label absolute X position within the image
     *
     * Value is in pixels, representing the distance between the left of the image and the label
     * If a negative value is used, it will represent the distance between the right of the image and the label
     *
     * Default value is null (so {@link image_text_position} is used)
     *
     * @access public
     * @var integer
     */
    var $image_text_x;

    /**
     * Sets the text label absolute Y position within the image
     *
     * Value is in pixels, representing the distance between the top of the image and the label
     * If a negative value is used, it will represent the distance between the bottom of the image and the label
     *
     * Default value is null (so {@link image_text_position} is used)
     *
     * @access public
     * @var integer
     */
    var $image_text_y;

    /**
     * Sets the text label padding
     *
     * Value is in pixels, representing the distance between the text and the label background border
     *
     * Default value is 0
     *
     * This setting can be overriden by {@link image_text_padding_x} and {@link image_text_padding_y}
     *
     * @access public
     * @var integer
     */
    var $image_text_padding;

    /**
     * Sets the text label horizontal padding
     *
     * Value is in pixels, representing the distance between the text and the left and right label background borders
     *
     * Default value is null
     *
     * If set, this setting overrides the horizontal part of {@link image_text_padding}
     *
     * @access public
     * @var integer
     */
    var $image_text_padding_x;

    /**
     * Sets the text label vertical padding
     *
     * Value is in pixels, representing the distance between the text and the top and bottom label background borders
     *
     * Default value is null
     *
     * If set, his setting overrides the vertical part of {@link image_text_padding}
     *
     * @access public
     * @var integer
     */
    var $image_text_padding_y;

    /**
     * Sets the text alignment
     *
     * Value is a string, which can be either 'L', 'C' or 'R'
     *
     * Default value is 'C'
     *
     * This setting is relevant only if the text has several lines.
     *
     * @access public
     * @var string;
     */
    var $image_text_alignment;

    /**
     * Sets the text line spacing
     *
     * Value is an integer, in pixels
     *
     * Default value is 0
     *
     * This setting is relevant only if the text has several lines.
     *
     * @access public
     * @var integer
     */
    var $image_text_line_spacing;

    /**
     * Sets the height of the reflection
     *
     * Value is an integer in pixels, or a string which format can be in pixels or percentage.
     * For instance, values can be : 40, '40', '40px' or '40%'
     *
     * Default value is null, no reflection
     *
     * @access public
     * @var mixed;
     */
    var $image_reflection_height;

    /**
     * Sets the space between the source image and its relection
     *
     * Value is an integer in pixels, which can be negative
     *
     * Default value is 2
     *
     * This setting is relevant only if {@link image_reflection_height} is set
     *
     * @access public
     * @var integer
     */
    var $image_reflection_space;

    /**
     * Sets the color of the reflection background (deprecated)
     *
     * Value is an hexadecimal color, such as #FFFFFF
     *
     * Default value is #FFFFFF
     *
     * This setting is relevant only if {@link image_reflection_height} is set
     *
     * This setting is now deprecated in favor of {@link image_default_color}
     *
     * @access public
     * @var string;
     */
    var $image_reflection_color;

    /**
     * Sets the initial opacity of the reflection
     *
     * Value is an integer between 0 (no opacity) and 100 (full opacity).
     * The reflection will start from {@link image_reflection_opacity} and end up at 0
     *
     * Default value is 60
     *
     * This setting is relevant only if {@link image_reflection_height} is set
     *
     * @access public
     * @var integer
     */
    var $image_reflection_opacity;

    /**
     * Flips the image vertically or horizontally
     *
     * Value is either 'h' or 'v', as in horizontal and vertical
     *
     * Default value is null (no flip)
     *
     * @access public
     * @var string;
     */
    var $image_flip;

    /**
     * Rotates the image by increments of 45 degrees
     *
     * Value is either 90, 180 or 270
     *
     * Default value is null (no rotation)
     *
     * @access public
     * @var string;
     */
    var $image_rotate;

    /**
     * Crops an image
     *
     * Values are four dimensions, or two, or one (CSS style)
     * They represent the amount cropped top, right, bottom and left.
     * These values can either be in an array, or a space separated string.
     * Each value can be in pixels (with or without 'px'), or percentage (of the source image)
     *
     * For instance, are valid:
     * <pre>
     * $foo->image_crop = 20                  OR array(20);
     * $foo->image_crop = '20px'              OR array('20px');
     * $foo->image_crop = '20 40'             OR array('20', 40);
     * $foo->image_crop = '-20 25%'           OR array(-20, '25%');
     * $foo->image_crop = '20px 25%'          OR array('20px', '25%');
     * $foo->image_crop = '20% 25%'           OR array('20%', '25%');
     * $foo->image_crop = '20% 25% 10% 30%'   OR ar