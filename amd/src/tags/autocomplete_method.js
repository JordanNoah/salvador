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
            const tags = data.map(function(tag) {
                const value = tag.id;
                let label = tag.name;
                if (tag.id === -1) {
                    label = 'Create: ' + tag.name;
                }
                return {label, value};
            });
            return tags;
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
                    methodname: 'local_digitalta_tags_get',
                    args: {searchText: query},
                    done: function(result) {
                        if (result.length === 0) {
                            success([{name: query, id: -1}]);
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