Anahita+
========

This is forked version of [Anahita](https://github.com/anahitasocial/anahita).
For general information see the original.
The following information focuses on differences between the versions.

## Installation

In order to use this fork instead of original Anahita, utilize
[Loading a package from VCS repository method](http://getcomposer.org/doc/05-repositories.md#vcs),
i.e. make [composer.json](https://github.com/anahitasocial/anahita-standard/blob/master/composer.json)
of your anahita application to be:

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

* fix joomla legacy not to issue strict standards notifications, fix method declarations
  in child classes to comply with php 5.4+ strict standards restrictions (though there is constant
  effort to get rid of joomla legacy, anahita codebase still strongly relies on it and seems to
  continue be that way for some time, thus in order to efficienly develop in php 5.4+ strict
  standards notifications are taken care of)
  [cc4c11a](https://github.com/kulbakin/anahita/commit/cc4c11a0fe647b84c390db03668a5ea4dd42c23a),
  [5ba8798](https://github.com/kulbakin/anahita/commit/5ba8798d19a90a3c1235e9bf81b8a17b8b3ee0d7)
* fix so it supports mixed key types in parameter, i.e. checks key type for each element instead
  of deciding on key type by first one
  [48a627c](https://github.com/kulbakin/anahita/commit/48a627c5e570429b65fea0da7d1cc454fb838537)
* fix internal helper method *AnHelperArray::getValueAtIndex()*
  [6e209f7](https://github.com/kulbakin/anahita/commit/6e209f780872af6c321e9ee7a6a3764d297b590e)
* fix com_pages revisions: make their listing, add and edit pages show 404 error instead of empty
  page or 500 error
  [7352d26](https://github.com/kulbakin/anahita/commit/7352d26311775f7203673f0200844cc03b38a1ac),
  [2b1c767](https://github.com/kulbakin/anahita/commit/2b1c767cfb599454981ac12ccf61c9cb53e06d88)
* fix *PlgStorageAbstract::_write()* by removing *$public* parameter which makes no sence
  and thus unused
  [83693a4](https://github.com/kulbakin/anahita/commit/83693a49317215f39a2593de619f71824869cc39)
* discard [anahitasocial/anahita@35b8e8d](https://github.com/anahitasocial/anahita/commits/35b8e8d10e68b483ea18cc67e70543a2ed98feee)
  and [anahitasocial/anahita@d9a68c5](https://github.com/anahitasocial/anahita/commits/d9a68c5c20b5961c7f996391f3ab423f1a8c4661):
  anahita+ supports note browsing introduced by earlier update
  [74fd14b](https://github.com/kulbakin/anahita/commit/74fd14b2f9c5221caaf3df913f0a4de6ea7055da),
  so mentioned anahita commits are irrelevant
* update *notes* component to support browse operation, i.e. now it is possible to navigate notes
  not only from stories feed but with dedicated listing (listing URL is http://DOMAIN/notes)
  [74fd14b](https://github.com/kulbakin/anahita/commit/74fd14b2f9c5221caaf3df913f0a4de6ea7055da)
* fix *stories* view for its toolbar to reflect *filter=leaders* selection as other componets do
  [7dc27fe](https://github.com/kulbakin/anahita/commit/7dc27fe9ce49a0fd5bb8e733da216f27569af8ca)
* fix *@paginator()* template helper to read *limit* parameter from supplied entityset instead
  of assigning default value of (20) twenty
  [7a49a31](https://github.com/kulbakin/anahita/commit/7a49a315c7822c9744e7e499ff943f630c25626d)
* ~~fix *portraitable* behavior to prevent it from generating the same filename for
  different attachments of the same user handled within same second
  [a2b3ef8](https://github.com/kulbakin/anahita/commit/a2b3ef8d56119de88fd14eac71b7d183104d1c22)~~
* fix *fileable* behavior so it doesn't rely on obsolete database columns,
  fix *mime_type()* helper function (replacement for depricated standard *mime_content_type()*)
  [f109fbd](https://github.com/kulbakin/anahita/commit/f109fbd2614a560691784de1bd3891ed441b5880)
* fix localization in admin area by passing page titles through translation function allowing them
  to be translated
  [c99f8f5](https://github.com/kulbakin/anahita/commit/c99f8f59fc88aad0b58ead888d68b480de6ad8f3)
* ~~fix *ComPeopleDomainEntityPerson* domain to prevent it from allowing any user pontentially
  gaining admin access for *site* application
  [b44eb70](https://github.com/kulbakin/anahita/commit/b44eb709f058777d1cd987e157e96456f7a18631)~~
* update *notifier* behavior to have method for sending notification to administrators
  [1d6ad19](https://github.com/kulbakin/anahita/commit/1d6ad19e722d19d2c7c6527b696809644960b65e)
* discard [anahitasocial/anahita@d34578f](https://github.com/anahitasocial/anahita/commit/d34578f91b3f2e44d4e2a43d22d8aa5a772d0f07):
  not constructive, anahita+ intends to keep listings of public items for guest users instead
  of completely restricting access to them as original anahita suggests
* fix *enableable* behavior
  [273b93e](https://github.com/kulbakin/anahita/commit/273b93e0ffa92a20ed8345cad0eff032093775bd),
  [bd6616f](https://github.com/kulbakin/anahita/commit/bd6616f5d4d26e7f1c3dacc9a652263d1456d407)
* fix profile page javascript error appearing on stream switch when there are no component specific
  composer form defined
  [4d163f9](https://github.com/kulbakin/anahita/commit/4d163f96af4f845ef55a994cede279d6ef36346a)
* fix query building logic to properly recognize relationship aliases
  [0f20b3e](https://github.com/kulbakin/anahita/commit/0f20b3e05bb118f71984f37f6d278206229040d1),
  i.e. make work

```php
$query = KService::get('com:base.domain.entity.subscription')->getRepository()->getQuery();
$query->order('subscriber.name', 'asc'); // without fix such sorting would not be possible due to relationship alias not being recognized
$result = $query->fetchSet();
```

* fix admin area to have proper *com://site/application.router* initialized when requested, i.e.
  make its *base_url* correspond to site application
  [291ec48](https://github.com/kulbakin/anahita/commit/291ec48f945d97b840d135d1029a7e26858bb94b)
* fix admin area to load vendor (aka managed by composer) packages
  [9b20178](https://github.com/kulbakin/anahita/commit/9b201780e23c5bde5964bbdf5a6533c14948e0d5)
* update admin area theme to remove excessive branding
  [b0ef7b0](https://github.com/kulbakin/anahita/commit/b0ef7b0e41a9368372c90887375e7f15987a5a9f)
* fix default sorting direction applied in browse actions of entity controllers when only sorting
  field is defined (caused by typo)
  [5ca6285](https://github.com/kulbakin/anahita/commit/5ca6285732e8bc2c65f79d630a73cb1c84b593f5)
* fix redirection logic for edit form to redirect back to entity view by default
  [60a8d6a](https://github.com/kulbakin/anahita/commit/60a8d6a287582957df7dd188d95e9fe6f2946043)
* update language trnaslation system to support plural forms
  [4d619fc](https://github.com/kulbakin/anahita/commit/4d619fcc3e2947984d7b0c43e1afccde32ddf729),
  [e984637](https://github.com/kulbakin/anahita/commit/e9846374be2a9328e3ccb9512d6ddbddae364324);
  also see [Translation](https://github.com/kulbakin/anahita/wiki/Translation) in project wiki
* make *subject* for *notification* entity an optional field allowing anonymous notifications
  issued by the system
  [d9a0d8a](https://github.com/kulbakin/anahita/commit/d9a0d8ab4359a473bb6f6157f7c13b86ff575b67)
* fix url construction logic misbihaving in some contexts
  [8591bca](https://github.com/kulbakin/anahita/commit/8591bca7f2546bbd22bcecff4a79d7a94d16d5f1),
  [d6a6129](https://github.com/kulbakin/anahita/commit/d6a61290ba3fb0974bc2bc342a254ad1005c8dc6)
* fix notification sending process not being able to work when called from under *admin* application
  [3deb292](https://github.com/kulbakin/anahita/commit/3deb2922c7497fb3be3a2f9de2d9d616acda3d4e)
* fix close buttons for default styled javascript modal windows
  [e3a3caa](https://github.com/kulbakin/anahita/commit/e3a3caacf9eb1d1a7632b3f2b861daaa2c6574e8)
* update *InfinitScroll* by removing not properly working *batchSize* option from javascript
  *Paginator* preventing it from loading several pages in background even though user never intented to scroll
  [3a54189](https://github.com/kulbakin/anahita/commit/3a541896da198f590448f604623b836f63b05632)
* make *dictionariable* behavior not to store null values in database
  [0226f71](https://github.com/kulbakin/anahita/commit/0226f715c919ed078214b220285682aaed502e66)
* fix delete cascading defined in entity relationships
  [820fa07](https://github.com/kulbakin/anahita/commit/820fa07278bc40937ff1bdc084c889753af69608)
* fix formatting date function not to modify input date
  [031d328](https://github.com/kulbakin/anahita/commit/031d328713f8b7599422f470c64c3f88beb682c4)
* fix timezone setting not storing non-integer time shift properly
  [56525e6](https://github.com/kulbakin/anahita/commit/56525e66213b6942b6231c985255cf66250b4c7e)
* fix *validate-remote* custom javascript input form field validator
  [66f8917](https://github.com/kulbakin/anahita/commit/66f8917e889b6129c4efba3f090a17ffdabdb946)
