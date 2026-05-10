<template>
	<div class="page-index" :style="pageBgStyle">
		<div class="page-index__inner">
		

			<div class="page-main">
				<div class="hero">
					<div class="hero__text">
						<p class="hero__hello">Hello</p>
						<div class="hero__line" aria-hidden="true" />
						<h2 class="hero__welcome">欢迎使用</h2>
						<h1 class="hero__title">NIUCLOUD Lite AI</h1>
					</div>
				
				</div>

				<section class="cards" aria-label="入口" @mouseleave="activeIndex = -1">
					<div
						v-for="(item, index) in entryCards"
						:key="item.title"
						class="entry-card"
						:class="{'is-active': isCardActive(index)}"
						:style="{
							'--card-bg-texture': `url(${imgCardBg})`,
							'--card-hover-bg': `url(${imgHoverBg})`,
							'--card-paopao': `url(${imgPaopao})`
						}"
						role="button"
						tabindex="0"
						@click="onCardClick(index, item.href)"
						@keydown.enter="onCardClick(index, item.href)"
						@mouseenter="activeIndex = index"
					>
						<div class="entry-card__content">
							<div class="entry-card__icon">
								<!-- 泡泡：paopao.png 由 .entry-card__icon::before 绘制，主图叠在其上 -->
								<img
									class="entry-card__img"
									:src="item.imageSrc"
									alt=""
									draggable="false"
								/>
							</div>
							<div class="entry-card__title">{{ item.title }}</div>
							<div class="entry-card__sub">{{ item.sub }}</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import bgUrl from '@/assets/images/index/background.png'
/** 卡片内白色/浅蓝泡泡光斑背景（与主图标分层） */
import imgPaopao from '@/assets/images/index/paopao.png'
import imgOfficial from '@/assets/images/index/official.png'
import imgMobile from '@/assets/images/index/mobile.png'
import imgAdmin from '@/assets/images/index/admin.png'
import imgGit from '@/assets/images/index/git.png'
import imgPc from '@/assets/images/index/pc.png'
import imgCardBg from '@/assets/images/index/cardbackground.png'
import imgHoverBg from '@/assets/images/index/hoverbackground.png'

/** 当前激活的卡片索引（-1 表示无悬停，此时保持第一个激活） */
const activeIndex = ref(-1)

/** 判断卡片是否应该激活 */
const isCardActive = (index: number) => {
	return activeIndex.value === index || (activeIndex.value === -1 && index === 0)
}

const pageBgStyle = {
	backgroundImage: `url(${bgUrl})`,
	backgroundSize: '100% 100%',
	backgroundRepeat: 'no-repeat',
	backgroundPosition: 'center'
}

const router = useRouter()

/** 与 `assets/images/index` 下切图一一对应 */
const entryCards: Array<{
	title: string
	sub: string
	href: string
	imageSrc: string
}> = [
	{ title: '官网', sub: '查看更多官网信息', imageSrc: imgOfficial, href: 'https://www.niucloud.com' },
	{ title: 'PC端', sub: '查看更多PC端信息', imageSrc: imgPc, href: '#' },
	{ title: '手机端', sub: '查看更多手机端信息', imageSrc: imgMobile, href: '#' },
	{ title: '网站后台', sub: '进入网站后台开启', imageSrc: imgAdmin, href: '#' },
	{ title: 'Git下载', sub: '进入GIT下载源码', imageSrc: imgGit, href: 'https://gitee.com/niucloud-team/niucloud-lite-ai' }
]
entryCards[2].href = import.meta.env.VITE_WAP_DOMAIN || `${ location.origin }/wap/`
entryCards[3].href = import.meta.env.VITE_ADMIN_DOMAIN || `${ location.origin }/admin/`

function onCardClick (_index: number, href: string) {
	if (!href || href === '#') return
	if (href.startsWith('http')) {
		window.open(href, '_blank')
		return
	}
	router.push(href)
}
</script>

<style lang="scss" scoped>
/* 设计画布宽度 1920；竖向至少铺满视口（小屏不强行 1080 避免溢出） */
.page-index {
	width: 100%;
	min-height: 100vh;
	box-sizing: border-box;
}

.page-index__inner {
	width: 100%;
	max-width: 1920px;
	margin: 0 auto;
	padding: 24px 0 32px;
	min-height: 100vh;
	display: flex;
	flex-direction: column;
	align-items: center;
	box-sizing: border-box;
}

@media (min-width: 1600px) and (min-height: 900px) {
	.page-index,
	.page-index__inner {
		min-height: 1080px;
	}
}

/* 顶栏、脚注以外的中间主区：Hero + 卡片 */
.page-main {
	flex: 1;
	display: flex;
	flex-direction: column;
	min-height: 0;
}

@media (max-width: 768px) {
	.page-index__inner {
		padding-left: 24px;
		padding-right: 24px;
	}

	.hero {
		padding-top: 64px;
	}

	.cards {
		grid-template-columns: 1fr;
		width: 100%;
	}

	.entry-card {
		width: 100%;
		height: auto;
		aspect-ratio: 224 / 300;
	}
}

.site-header {
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-wrap: wrap;
	gap: 16px;
	padding-bottom: 16px;
	border-bottom: 1px solid rgba(1, 1, 1, 0.08);
}

.site-header__brand {
	display: flex;
	align-items: center;
	gap: 8px;
}

.site-header__logo {
	font-size: 18px;
	font-weight: 700;
	color: #010101;
	letter-spacing: 0.12em;
	font-family:
		'Source Han Sans CN',
		'Noto Sans SC',
		'PingFang SC',
		'Microsoft YaHei',
		sans-serif;
}

.site-header__nav {
	display: flex;
	align-items: center;
	gap: 12px;
	font-size: 14px;
}

.site-header__link {
	color: #888;
	font-size: 13px;
	text-decoration: none;
	font-family:
		'Source Han Sans CN',
		'Noto Sans SC',
		sans-serif;

	&:hover {
		color: #2774e9;
	}
}

.site-header__sep {
	color: #ccc;
	user-select: none;
}

/* 设计稿：标题栏底到 Hello 顶 112px */
.hero {
	display: flex;
	flex-wrap: wrap;
	align-items: flex-start;
	justify-content: space-between;
	gap: clamp(24px, 4vw, 48px);
	padding-top: 112px;
	box-sizing: border-box;
}

.hero__text {
	flex: 1 1 280px;
	min-width: 0;
}

/* Hello 按设计稿 */
.hero__hello {
	margin: 0;
	color: #010101;
	font-family:
		'Source Han Sans CN',
		'Noto Sans SC',
		'PingFang SC',
		'Microsoft YaHei',
		sans-serif;
	font-size: clamp(22px, 3vw, 28px);
	font-style: normal;
	font-weight: 700;
	line-height: 1;
}

/* 设计稿：Hello 与装饰线间距约 8～10px */
.hero__line {
	height: 6px;
	width:  clamp(30px, 3vw, 40px);
	margin-top: 8px;
	background: #010101;
}

/* 装饰线 → 欢迎使用：约 20～24px */
.hero__welcome {
	margin: 24px 0 17px;
	font-size: clamp(28px, 3.4vw, 36px);
	font-weight: 500;
	color: #010101;
	line-height: 54px;
	font-family:
		'Source Han Sans CN',
		'Noto Sans SC',
		'PingFang SC',
		sans-serif;
}

/* 与「欢迎使用」同层级字号（设计稿两行主标题接近） */
.hero__title {
	font-size: clamp(28px, 3.4vw, 36px);
	font-weight: 700;
	color: #010101;
	line-height: 1;
	letter-spacing: 0.02em;
	font-family:
		'Source Han Sans CN',
		'Noto Sans SC',
		'PingFang SC',
		sans-serif;
}

.hero__art {
	flex: 0 1 420px;
	max-width: min(100%, 480px);
	margin-left: auto;
}

.hero__art img {
	display: block;
	width: 100%;
	height: auto;
	object-fit: contain;
}

/* 设计稿：5 张一行，单卡 224×300px，间距 20px（总宽约 1200px） */
.cards {
	display: grid;
	grid-template-columns: repeat(5, 224px);
	gap: 20px;
	margin-top: clamp(36px, 6vw, 56px);
	width: max-content;
	max-width: 100%;
	box-sizing: border-box;
	align-self: flex-start;
}

@media (max-width: 1280px) {
	.cards {
		grid-template-columns: repeat(3, 224px);
	}

	.page-index__inner {
		padding-left: 80px;
	}
}

@media (max-width: 800px) {
	.cards {
		grid-template-columns: repeat(2, minmax(140px, 1fr));
	}
}

.entry-card {
	isolation: isolate;
	position: relative;
	width: 224px;
	height: 300px;
	max-width: 100%;
	box-sizing: border-box;
	border-radius: 0;
	padding: 0;
	text-align: center;
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-shrink: 0;
	/* 勿 hidden：泡泡图大于图标区且上移，会被裁掉导致「看不到泡泡」 */
	overflow: visible;
	transition:
		box-shadow 0.3s ease,
		background-color 0.3s ease,
		background-image 0.3s ease;

	border: none;
	outline: none;
	box-shadow: 0 4px 20px rgba(22, 118, 255, 0.12);

	/*
	 * 卡片背景图 cardbackground 作为最底层嵌入，两层渐变叠在上方（正片叠底），
	 * 默认与悬浮共用同一套叠色逻辑，纹理始终可见且整体观感与原先接近。
	 */
	background-color: #fff;
	background-image:
		linear-gradient(180deg, #e8f6ff 0%, #ffffff 100%),
		linear-gradient(180deg, #f2fdff 0%, #ffffff 76.53%),
		var(--card-bg-texture);
	background-repeat: no-repeat;
	background-size: 100% 100%, 100% 100%, cover;
	background-position: center, center, center;
	background-blend-mode: multiply, multiply, normal;

	.entry-card__title {
		color: #333;
		font-size: 18px;
		transition: color 0.3s ease;
		font-weight: 400;
	}

	.entry-card__sub {
		color: #999;
		transition: color 0.3s ease;
		font-size: 14px;
		font-weight: 400;
	}

	/* 悬浮：整卡使用 hoverbackground.png；文案在 .entry-card__content（z-index:1）之上不受影响 */
	&.is-active,
	&:hover,
	&:focus-visible {
		background-color: #ffffff;
		background-image: var(--card-hover-bg);
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		box-shadow: 0 8px 28px rgba(22, 118, 255, 0.28);

		.entry-card__title {
			color: #fff;
		}

		.entry-card__sub {
			color: rgba(255, 255, 255, 0.92);
		}

		.entry-card__icon::before {
			opacity: 0.88;
		}
	}

	&:focus-visible {
		outline: 2px solid #1676ff;
		outline-offset: 3px;
	}
}

.entry-card__content {
	position: relative;
	z-index: 1;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	width: 100%;
	height: 100%;
	padding: 20px 14px 22px;
	box-sizing: border-box;
}

@media (max-width: 640px) {
	.entry-card {
		width: min(224px, calc(50vw - 28px));
		height: auto;
		min-height: 260px;
		aspect-ratio: 224 / 300;
	}
}

/* 图标区：伪元素铺底 = paopao 泡泡，主图叠在上层（不用 mix-blend，避免浅色卡上看不见） */
.entry-card__icon {
	position: relative;
	z-index: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 152px;
	height: 152px;
	flex: 0 0 auto;
	margin-top: -4px;
}

.entry-card__icon::before {
	content: '';
	position: absolute;
	left: 50%;
	top: 50%;
	z-index: 0;
	width: 228px;
	height: 228px;
	margin-left: -114px;
	margin-top: -122px;
	background-image: var(--card-paopao);
	background-repeat: no-repeat;
	background-position: 50% 40%;
	background-size: contain;
	opacity: 0.78;
	pointer-events: none;
	transition: opacity 0.3s ease;
}

.entry-card__img {
	position: relative;
	z-index: 1;
	display: block;
	width: auto;
	max-width: 80px;
	max-height: 72px;
	object-fit: contain;
	user-select: none;
	pointer-events: none;
}

.entry-card__title {
	margin: 0;
	font-size: 17px;
	font-weight: 700;
	color: #111;
	line-height: 1.35;
	flex: 0 0 auto;
}

.entry-card__sub {
	margin: 0;
	margin-top: 6px;
	font-size: 12px;
	line-height: 1.45;
	color: #666;
	flex: 0 0 auto;
	max-width: 100%;
}

.page-footer {
	margin-top: auto;
	padding-top: clamp(40px, 8vh, 72px);
	text-align: center;
	color: #999;
	font-size: 13px;
	line-height: 1.7;
}

.page-footer__icp {
	margin: 0;
}

.page-footer__slogan {
	margin: 8px 0 0;
}

.page-footer__brand {
	margin: 12px 0 0;
	font-size: 15px;
	font-weight: 700;
	letter-spacing: 0.2em;
	color: #666;
}
</style>
