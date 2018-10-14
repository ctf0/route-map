<template>
    <div class="scroll-btns">
        <button class="button is-danger" @click="scrollTop()"><icon scale="0.7" name="arrow-up"/></button>
        <button class="button is-danger" @click="scrollBottom()"><icon scale="0.7" name="arrow-down"/></button>
    </div>
</template>

<style scoped lang="scss">
    .scroll-btns {
        position: fixed;
        right: 1rem;
        bottom: 5rem;
        display: flex;
        flex-direction: column;
    }

    button {
        opacity: 0.5;

        &:first-of-type {
            margin-bottom: 0.25rem;
        }

        &:focus {
            box-shadow: none !important;
        }

        &:hover {
            opacity: 1;
        }
    }
</style>

<script>
import animateScrollTo from './animated-scroll-to'

export default {
    methods: {
        scrollTop() {
            this.scrollTO(0)
        },
        scrollBottom() {
            this.scrollTO(document.body.scrollHeight)
        },
        scrollTO(offset) {
            animateScrollTo(offset, {
                speed: 500,
                minDuration: 250,
                maxDuration: 1000
            })
        }
    }
}
</script>
