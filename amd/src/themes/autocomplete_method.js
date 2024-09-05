define(['core/ajax'], function(Ajax) {
    return {
        /**
         * Process the results returned from transport (convert to value + label)
         *
         * @method processResults
         * @param {String} selector
         * @param {Array} data
         * @return {Array}
         */
        processResults: function(selector, data) {
            const themes = data.map(function(theme) {
                const value = theme.id;
                let label = theme.name;
                if (theme.id === -1) {
                    return false;
                }
                return {label, value};
            });
            return themes;
        },

        /**
         * Fetch results based on the current query. This also renders each result from a template before returning them.
         *
         * @method transport
         * @param {String} searchText
         * @param {String} query
         * @param {Function} success
         * @param {Function} failure
         */
        transport: function(searchText, query, success, failure) {
            {
                Ajax.call([{
                    methodname: 'local_digitalta_themes_get',
                    args: {searchText: query},
                    done: function(result) {
                        if (result.length === 0) {
                            success([]);
                        } else {
                            success(result);
                        }
                    },
                    fail: failure
                }]);
            }
        }
    };
});
