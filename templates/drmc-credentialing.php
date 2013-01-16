<?php
/**
 * Template Name: Credentialing List Template
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>



<!-- ******* -->
<?php
$default_dir = "/medstaff-docs/drmc-credentialing/"; // lists files only for the directory which this script is run from

function file_ext_strip($filename) {
    return preg_replace('/\.[^.]*$/', '', $filename);
}

function file_replace_spacer($filename) {
	return preg_replace('/[_-]+/', ' ', $filename);
}

function file_title_case($filename) {
	return ucwords($filename);
}
	
function list_directory($dir) {
	$narray=array();

	$dir_handle = @opendir($dir) or die("Unable to open $dir");
	$i=0;
	$skip_files = array(".", "..", ".htaccess", "index.php");
	//while($file = readdir($dir_handle)) {
	while (false !== ($file = readdir($dir_handle))) {
		if(!in_array($file, $skip_files)) {
			$narray[$i]=$file;
			$i++;
		}
	}
	natcasesort($narray); // case-insensitive sort
	return $narray;
	closedir($dir_handle); //closing the directory
}

// print out html
echo "\t" . '<ul>' . "\r\n\t";
$directory_array = list_directory(WP_CONTENT_DIR . $default_dir);
for($i=0; $i<sizeof($directory_array); $i++) {
	$fn = $directory_array[$i];
	$fn = file_ext_strip($fn);
	$fn = file_replace_spacer($fn);
	$fn = file_title_case($fn);
	echo "<li><a href=".chr(34) . content_url() . $default_dir . $directory_array[$i] .chr(34). ">" . $fn . "</a></li>\r\n\t";
}
echo '</ul>' . "\r\n\t";
?>

<!-- ****** -->

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>