<template>
    <div>
        <div class="form-group">
            <input
                :placeholder="placeholder"
                :value='searchTerm'
                @input='onInput'
                autofocus
                class="form-control"
                required="required"
                type="search">
        </div>
        <span class="badge badge-light size" v-if="conceptsCount > -1">[{{conceptsCount}}]</span>
        <Result :concepts="concepts" :noResult="noResult" :perform-search="performSearch"/>
    </div>
</template>

<script>
    import Result from './Result'
    import debounce from 'lodash.debounce';

    const axios = require('axios');
    export default {
        data: () => {
            return {
                conceptsCount: -1,
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
                    debounce(this.query, 700)()
                }
            },
            query() {
                let queryParameters = {
                    params: {
                        search: this.searchTerm
                    }
                }
                axios
                    .get(referentialApiUrl, queryParameters)
                    .then(this.response)
                    .then(() => this.performSearch = false);
            },
            response(response) {
                this.concepts = response.data;
                this.conceptsCount = this.concepts.length
            },
            onInput(event) {
                this.searchTerm = event.target.value;
                this.search()
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
    };
</script>

<style>
    span.size {
        font-size: .60rem;
    }

    .form-group {
        margin-bottom: .0rem;
    }
</style>
