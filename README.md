Anahita+
========

This is forked version of [Anahita](https://github.com/anahitasocial/anahita). For general information see the original.
The following information focuses on differences between the versions.

## Installation

In order to use this fork instead of original Anahita, use [Loading a package from VCS repository method](http://getcomposer.org/doc/05-repositories.md#vcs),
i.e. make [composer.json](https://github.com/anahitasocial/anahita-standard/blob/master/composer.json) of your anahita application to be:

```json
{
    "name" : "anahita/project",
    "type" : "project",
    "license": "GPL-3.0",
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/kulbakin/anahita"
        }
    ],
    "require": {
        "php": ">=5.3.3",
        "anahita/anahita": "dev-master"
    },
    "minimum-stability": "dev"
}
```

## Changelog

The chengelog lists fixes and updates which are not present in the original Anahita.
If a patch finds its way upstream or a similar one intorduced there, the log entry is
striked out. There is strong correlation with commit history, so it is recommended
to look into corresponding commit comments for additional details regarding introduced
changes.

> Since this fork among other things strives to introduce consistent
> [coding style](https://github.com/kulbakin/anahita/wiki/Coding-Standard),
> especially whitespace policy, commit patches may show significant changes between
> original and updated versions, though in reality only a couple lines are actually
> modified, the rest are just whitespace changes. Thus it is advised to use advanced
> [difftool](https://www.kernel.org/pub/software/scm/git/docs/git-difftool.html),
> e.g. [KDiff3](http://kdiff3.sourceforge.net/), for analyzing changes.

* update language trnaslation system to support plural forms
  [4d619fc](https://github.com/kulbakin/anahita/commit/4d619fcc3e2947984d7b0c43e1afccde32ddf729), [e984637](https://github.com/kulbakin/anahita/commit/e9846374be2a9328e3ccb9512d6ddbddae364324);
  also see [Translation](https://github.com/kulbakin/anahita/wiki/Translation) in project wiki
* make *subject* for *notification* entity an optional field allowing anonymous notifications
  issued by the system [d9a0d8a](https://github.com/kulbakin/anahita/commit/d9a0d8ab4359a473bb6f6157f7c13b86ff575b67)
* fix url construction logic misbihaving in some contexts
  [8591bca](https://github.com/kulbakin/anahita/commit/8591bca7f2546bbd22bcecff4a79d7a94d16d5f1), [d6a6129](https://github.com/kulbakin/anahita/commit/d6a61290ba3fb0974bc2bc342a254ad1005c8dc6)
* fix notification sending process not being able to work when called from under *admin*
  application [3deb292](https://github.com/kulbakin/anahita/commit/3deb2922c7497fb3be3a2f9de2d9d616acda3d4e)
* fix close buttons for default styled javascript modal windows [e3a3caa](https://github.com/kulbakin/anahita/commit/e3a3caacf9eb1d1a7632b3f2b861daaa2c6574e8)
* update *InfinitScroll* by removing not properly working *batchSize* option from javascript *Paginator* preventing it from loading
  several pages in background even though user never intented to scroll [3a54189](https://github.com/kulbakin/anahita/commit/3a541896da198f590448f604623b836f63b05632)
* make *dictionariable* behavior not to store null values in database [0226f71](https://github.com/kulbakin/anahita/commit/0226f715c919ed078214b220285682aaed502e66)
* fix delete cascading defined in entity relationships [820fa07](https://github.com/kulbakin/anahita/commit/820fa07278bc40937ff1bdc084c889753af69608)
* fix formatting date function not to modify input date [031d328](https://github.com/kulbakin/anahita/commit/031d328713f8b7599422f470c64c3f88beb682c4)
* fix timezone setting not storing non-integer time shift properly [56525e6](https://github.com/kulbakin/anahita/commit/56525e66213b6942b6231c985255cf66250b4c7e)
* fix *validate-remote* custom javascript input form field validator [66f8917](https://github.com/kulbakin/anahita/commit/66f8917e889b6129c4efba3f090a17ffdabdb946)
