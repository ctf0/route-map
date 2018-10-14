<script>
import debounce from 'lodash/debounce'
import Scroll from './Scroll/btns.vue'

export default {
    components: {Scroll},
    name: 'route-map',
    props: ['groupNames'],
    data() {
        return {
            searchFor: null,
            searchFieldType: 'Name',
            searchFields: [
                'Group',
                'Methods',
                'Domain',
                'Url',
                'Name',
                'Action',
                'Middleware'
            ],
            hiddenGroups: [],
            expand: true
        }
    },
    mounted() {
        // hide domain if empty
        if (!document.querySelector('.domain').value) {
            // hide cells
            Array.from(document.querySelectorAll('.domain, .hide-domain')).forEach((e) => {
                e.classList.add('is-hidden')
            })

            // remove searchFields item
            this.searchFields.splice(this.searchFields.indexOf('Domain'), 1)
        }

        // add border to last item in table
        // let empty = document.querySelectorAll('.empty-cell')
        // let last = empty.length - 1
        // empty[last].style.borderBottom = '1px solid #dbdbdb'
    },
    methods: {
        resetSearch() {
            this.searchFor = null
        },
        runSearch: debounce(function(val) {
            let col = this.searchFieldType.toLowerCase()

            if (col == 'group') {
                Array.from(document.querySelectorAll('[data-group-name]')).forEach((e) => {
                    if (!e.dataset.groupName.includes(val)) {
                        e.closest('thead')
                            ? false // dont hide the main header
                            : e.classList.add('is-hidden')
                    }
                })
            } else {
                Array.from(document.querySelectorAll(`[data-${col}]`)).forEach((item) => {
                    if (!item.textContent.trim().toLowerCase().includes(val)) {
                        item.closest('tr').classList.add('is-hidden')
                    }
                })
            }
        }, 500),
        clearHidden() {
            Array.from(document.querySelectorAll('tr.is-hidden')).forEach((e) => {
                e.classList.remove('is-hidden')
            })
        },
        toggleGroup(name) {
            let hg = this.hiddenGroups

            if (hg.includes(name)) {
                hg.splice(hg.indexOf(name), 1)
                Array.from(document.querySelectorAll(`[data-group-name="${name}"]`)).forEach((e) => {
                    e.classList.remove('is-hidden')
                })
            } else {
                hg.push(name)
                Array.from(document.querySelectorAll(`[data-group-name="${name}"]:not([data-toggle])`)).forEach((e) => {
                    e.classList.add('is-hidden')
                })
            }
        },
        toggleExpand() {
            this.expand = !this.expand

            this.hiddenGroups = !this.expand ? this.groupNames : []

            Array.from(document.querySelectorAll('[data-group-name]:not([data-toggle])')).forEach((e) => {
                e.classList.toggle('is-hidden', !this.expand)
            })
        }
    },
    watch: {
        searchFor(val) {
            if (val) {
                this.clearHidden()
                this.runSearch(val)
            } else {
                this.clearHidden()
            }
        },
        searchFieldType(val) {
            let search = this.searchFor

            if (search) {
                this.clearHidden()
                this.runSearch(search)
            }
        }
    },
    render() {}
}
</script>
