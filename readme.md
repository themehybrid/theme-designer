# Theme Designer

*Are you a WordPress theme author?*

Then, this plugin may be just right for you.  Theme Designer creates a system for managing your theme releases on your own Web site.

It's actually a project that I've been building and tweaking since I launched my own site, [Theme Hybrid](http://themehybrid.com), way back in 2008.  I use it to run the [themes section](http://themehybrid.com/themes) on the site, so it has tons of useful tools for doing just that.  It's just that I've never packaged it all up to make it useful for others until now.

## Features

**Template Tags** are the heart and soul of this plugin. There are tons of useful functions located in the `inc/template` folder that you'll want to use.  These are well documented in-code, so theme authors should be able to figure these out.

**WordPress.org Integration** is a useful feature if you have themes that are hosted there.  If you have this activated, you can add in the slug on the edit theme screen, which will give you all the info back from there about your theme.  Dig into the `inc/wporg` folder for the code behind that.

There are two **built-in taxonomies** called `theme_subject` (hierarchical) and `theme_feature` (non-hierarchical).  These will give you some basic organization to run with.  Of course, you're free to add custom taxonomies if needed.

**Data, data, data.** There's many different pieces of data associated with themes.  There are several fields where you can enter that data on the edit theme screen.

The plugin is **easy to extend** with custom features.  There's a hook for everything.  And, if there's one missing, I'll be happy to add it in.

The plugin isn't going to make a lot of effort to show everything on the front end.  I figured most theme authors will actually want to handle the front end display of stuff on their site.  You can use the regular ol' WP **template hierarchy** or check out the basic hierarchy in `inc/core/filters.php`.

## Professional Support

If you need professional plugin support from me, the plugin author, you can access the support forums at [Theme Hybrid](http://themehybrid.com/board/topics), which is a professional WordPress help/support site where I handle support for all my plugins and themes for a community of 60,000+ users (and growing).

## Copyright and License

This project is licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2015-2016 &copy; [Justin Tadlock](http://justintadlock.com).
