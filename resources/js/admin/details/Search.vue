<template>
    <div class="form-group">
        <input
            :placeholder="placeholder"
            :value='searchTerm'
            @input='evt => {
                searchTerm = evt.target.value
                search()
            }'
            autofocus
            class="form-control"
            required="required"
            type="search">
        <br>
        <Result :concepts="concepts" :noResult="noResult" :perform-search="performSearch"/>
    </div>
</template>

<script>
    import Result from './Result'
    import debounce from "lodash.debounce";

    const axios = require('axios');

    export default {
        created() {
            this.searchAction = debounce(search, 700)
        },
        data: () => {
            return {
                placeholder: `Rechercher dans ${referential}`,
                searchTerm: '',
                performSearch: false,
                concepts: [],
            }
        },
        methods: {
            search() {
                if (this.searchTerm) {
                    this.performSearch = true
                    this.searchAction(this)
                }
            },
        },
        computed: {
            noResult: function () {
                return !this.performSearch && this.searchTerm && !this.concepts.length
            }
        },
        components: {
            Result
        }
    }

    function search($this) {
        axios.get(referentialApiUrl, {
            params: {
                search: $this.searchTerm
            }
        })
            .then((response) => {
                $this.concepts = response.data
            })
            .then(() => {
                $this.performSearch = false;
            });
    }
</script>
