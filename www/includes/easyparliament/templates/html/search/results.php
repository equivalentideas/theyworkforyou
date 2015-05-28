<div class="full-page">
    <div class="full-page__row search-page">

        <form>
            <div class="search-page__section search-page__section--search">
                <div class="search-page__section__primary">
                    <p class="search-page-main-inputs">
                        <input type="text" name="q" value="<?= $searchstring ?>" class="form-control">
                        <button type="submit" class="button">Search</button>
                    </p>
                    <p>
                        <a href="#options" class="search-options-toggle js-toggle-search-options">Advanced search</a>
                    </p>
                </div>
            </div>

            <div class="search-page__section search-page__section--options" id="options">
                <div class="search-page__section__primary">
                    <h2>Advanced search</h2>

                    <h4>Date range</h4>
                    <div class="search-option">
                        <div class="search-option__control search-option__control--date-range">
                            <input type="text" class="form-control">
                            <span>to</span>
                            <input type="text" class="form-control">
                        </div>
                        <div class="search-option__hint">
                            <p>You can give a <strong>start date, an end date, or both</strong> to restrict results to a particular date range. A missing end date implies the current date, and a missing start date implies the oldest date we have in the system. Dates can be entered in any format you wish, e.g. <strong>&ldquo;3rd March 2007&rdquo;</strong> or <strong>&ldquo;17/10/1989&rdquo;</strong></p>
                        </div>
                    </div>

                    <h4>Person</h4>
                    <div class="search-option">
                        <div class="search-option__control">
                            <input type="text" class="form-control">
                        </div>
                        <div class="search-option__hint">
                            <p>Enter a name here to restrict results to contributions only by that person.</p>
                        </div>
                    </div>

                    <h4>Section</h4>
                    <div class="search-option">
                        <div class="search-option__control">
                            <select name="section">
                                <option></option>
                                <optgroup label="UK Parliament">
                                    <option value="uk">All UK</option>
                                    <option value="debates">House of Commons debates</option>
                                    <option value="whall">Westminster Hall debates</option>
                                    <option value="lords">House of Lords debates</option>
                                    <option value="wrans">Written answers</option>
                                    <option value="wms">Written ministerial statements</option>
                                    <option value="standing">Bill Committees</option>
                                    <option value="future">Future Business</option>
                                </optgroup>
                                <optgroup label="Northern Ireland Assembly">
                                    <option value="ni">Debates</option>
                                </optgroup>
                                <optgroup label="Scottish Parliament">
                                    <option value="scotland">All Scotland</option>
                                    <option value="sp">Debates</option>
                                    <option value="spwrans">Written answers</option>
                                </optgroup>
                             </select>
                        </div>
                        <div class="search-option__hint">
                            <p>Restrict results to a particular parliament or assembly that we cover (e.g. the Scottish Parliament), or a particular type of data within an institution, such as Commons Written Answers.</p>
                        </div>
                    </div>

                    <h4>Column</h4>
                    <div class="search-option">
                        <div class="search-option__control">
                            <input type="text" class="form-control">
                        </div>
                        <div class="search-option__hint">
                            <p>If you know the actual Hansard column number of the information you are interested in (perhaps you&rsquo;re looking up a paper reference), you can restrict results to that.</p>
                        </div>
                    </div>

                    <p><button type="submit" class="button">Search</button></p>
                </div>
            </div>
        </form>

        <?php if ( $searchstring ) { ?>
        <div class="search-page__section search-page__section--results">
            <div class="search-page__section__primary">
                <?php if ( $members ) { ?>
                <h2>People matching <em class="current-search-term"><?= $info['s'] ?></em></h2>

                <?php foreach ( $members as $member ) { ?>
                <div class="search-result search-result--person">
                    <img src="<?= $member->image()['url'] ?>" alt="">
                    <h3 class="search-result__title"><a href="<?= $member->url() ?>"><?= $member->full_name() ?></a></h3>
                    <p class="search-result__description">
                    <?php $details = $member->getMostRecentMembership(); ?>
                    <?= $details['left_house'] != '9999-12-31' ? 'Former ' : '' ?><?= $details['party'] ? $details['party'] . ' ' : '' ?><?= $details['rep_name'] ?>, <?= $details['cons'] ? $details['cons'] . ', ' : ''?><?= format_date($details['entered_house'], SHORTDATEFORMAT) ?> &ndash; <?= $details['left_house'] != '9999-12-31' ? format_date($details['left_house'], SHORTDATEFORMAT) : '' ?>
                    </p>
                </div>
                <?php } ?>

                <hr>
                <?php } ?>

                <h2>
                <?php if ( $pagination_links ) { ?>
                Results <?= $pagination_links['first_result'] ?>&ndash;<?= $pagination_links['last_result'] ?> of <?= $info['total_results'] ?>
                <?php } else if ( $info['total_results'] == 1 ) { ?>
                The only result
                <?php } else if ( $info['total_results'] == 0 ) { ?>
                There were no results
                <?php } else { ?>
                All <?= $info['total_results'] ?> results
                <?php } ?>
                for <em class="current-search-term"><?= _htmlentities($info['s']) ?></em></h2>

                <?php if ( $info['total_results'] ) { ?>
                <ul class="search-result-display-options">
                    <li>Sorted by relevance</li>
                    <li>Sort by date: <a href="#">newest</a> / <a href="#">oldest</a></li>
                    <li><a href="./by-person.php">Group by person</a></li>
                </ul>
                <?php } ?>

                <?php foreach ( $rows as $result ) { ?>
                <div class="search-result search-result--generic">
                <h3 class="search-result__title"><a href="#"><?= $result['parent']['body'] ?></a> (<?= format_date($result['hdate'], SHORTDATEFORMAT) ?>)</h3>
                    <p class="search-result__description"><?= isset($result['speaker']) ? $result['speaker']['name'] . ': ' : '' ?><?= $result['extract'] ?></p>
                </div>
                <?php } ?>

                <hr>

                <?php if ( $pagination_links ) { ?>
                <div class="search-result-pagination">
                    <?php if ( isset($pagination_links['prev']) ) { ?>
                    <a href="<?= $pagination_links['firstpage']['url'] ?>">&lt;&lt;</a>
                    <a href="<?= $pagination_links['prev']['url'] ?>">&lt;</a>
                    <?php }
                    foreach ( $pagination_links['nums'] as $link ) { ?>
                    <a href="<?= $link['url'] ?>"<?= $link['current'] ? ' class="search-result-pagination__current-page"' : '' ?>><?= $link['page'] ?></a>
                    <?php }
                    if ( isset($pagination_links['next']) ) { ?>
                    <a href="<?= $pagination_links['next']['url'] ?>">&gt;</a>
                    <a href="<?= $pagination_links['lastpage']['url'] ?>">&gt;&gt;</a>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>

            <div class="search-page__section__secondary search-page-sidebar">
                <h2>Create an alert</h2>
                <p class="search-alert-type search-alert-type--email">
                    <a href="#">Subscribe to an email alert</a>
                    for <em class="current-search-term">Peacock</em>
                </p>
                <p class="search-alert-type search-alert-type--rss">
                    Or <a href="#">get an RSS feed</a>
                    of new matches as they happen
                </p>

                <h2>Did you find what you were looking for?</h2>
                <form method="post" action="http://survey.mysociety.org">
                    <input type="hidden" name="sourceidentifier" value="twfy-mini-2">
                    <input type="hidden" name="datetime" value="1431962861">
                    <input type="hidden" name="subgroup" value="0">
                    <input type="hidden" name="user_code" value="123">
                    <input type="hidden" name="auth_signature" value="123">
                    <input type="hidden" name="came_from" value="http://www.theyworkforyou.com/search/?answered_survey=2">
                    <input type="hidden" name="return_url" value="http://www.theyworkforyou.com/search/?answered_survey=2">
                    <input type="hidden" name="question_no" value="2">
                    <p>
                        <label><input type="radio" name="find_on_page" value="1"> Yes</label>
                        <label><input type="radio" name="find_on_page" value="0"> No</label>
                    </p>
                    <p>
                        <input type="submit" class="button small" value="Submit answer">
                    </p>
                </form>
            </div>
        </div>
        <?php } ?>

    </div>
</div>

<script type="text/javascript">
$(function(){
  $('.js-toggle-search-options').on('click', function(e){
    e.preventDefault();
    var id = $(this).attr('href');
    if($(id).is(':visible')){
      $('.js-toggle-search-options[href="' + id + '"]').removeClass('toggled');
      $(id).slideUp(250);
    } else {
      $('.js-toggle-search-options[href="' + id + '"]').addClass('toggled');
      $(id).slideDown(250);
    }
  });

  $( $('.js-toggle-search-options').attr('href') ).hide();
});
</script>
