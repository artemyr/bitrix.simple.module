<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arParams
 * @var array $arResult
 */
//dump($arResult);
?>
<script src="<?=SITE_TEMPLATE_PATH?>/assets/js/vue.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/assets/js/axios.js"></script>
<div id="vue-show-more" style="margin-top: 30px">
    <div class="row">
        <div
                v-for="(post, index) in posts"
                class="col-md-6"
                :class="index | changeClass"
        >
            <div class="project__item"
                 :style="{backgroundImage: 'url('+ post.PREVIEW_PICTURE_SRC +')'}">
                <a :href="post.DETAIL_PAGE_URL"></a>
                <div class="project__item-tx">
                    <div class="project__item-tx-tit" v-html="post.NAME"></div>
                    <div class="project__item-tx-tt" v-html="post.PREVIEW_TEXT"></div>
                    <div class="project__item-tx-arrow"><img src="<?=SITE_TEMPLATE_PATH?>/assets/images/svg/arrow3.svg" alt=""></div>
                </div>
            </div>
        </div>
    </div>
    <div class="button-center"
        v-if="SHOW_MORE"
    >
        <a class="button button-bord"
           @click.prevent="showMore()"
           :data-ajax-iblock="arParams.iblock"
           :data-ajax-count="arParams.count"
           :href="arParams.PAGEN_1"
        >
            <span>Показать еще<svg><use xlink:href="#plus"></use></svg></span>
        </a>
    </div>
</div>
<script>
    var app = new Vue({
        el: '#vue-show-more',
        data: {
            posts:[],
            arParams: {
                iblock: <?= $arParams['IBLOCK_ID'] ?>,
                count: <?= $arParams['NEWS_COUNT'] ?>,
                PAGEN_1: <?= $arParams['PAGEN'] ?>,
                filter: "<?= $arParams['FILTER_STRING'] ?>",
                clear_cache: 'Y'
            },
            SHOW_MORE: true
        },
        methods: {
            async fetchPosts() {
                try {
                    let gets = '';
                    let getsAr = [];
                    for (const [key, value] of Object.entries(this.arParams)) {
                        getsAr.push(`${key}=${value}`);
                    }
                    gets = getsAr.join('&');
                    const response = await axios.get(`/ajax/vue-test-axios.php?${gets}`);

                    response.data.posts.forEach((el) => {
                        this.posts.push(el);
                    });
                    this.SHOW_MORE = response.data.SHOW_MORE;
                    this.arParams.PAGEN_1++;
                } catch (e) {
                    console.log(e);
                    alert('ошибка')
                }
            },
            showMore() {
                this.fetchPosts();
            }
        },
        filters: {
            changeClass : function(index){
                const classes = <?= $arParams['TILE_MODE'] ?>;
                let cur = 0;

                for (let i = 0; i <= index; i++){
                    if(cur < 8)
                        cur++;
                    else
                        cur = 1;
                }
                return 'col-lg-'+classes[cur];
            }
        },
    })
</script>