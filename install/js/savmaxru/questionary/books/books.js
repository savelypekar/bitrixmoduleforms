;(function()
{
	BX.namespace("BX.Vendor.Extension");

	BX.Vendor.Extension.Book =
	{
		get: function(id)
		{
			return new Promise(function(resolve)
			{
				BX.ajax.runAction("savmaxru:modulename.book.get", {
					data: {id: id}
				}).then(function(response)
				{
					resolve(response.data);

				}.bind(this)).catch(function(response)
				{
					console.error(response.errors);
				});
			});

		}
	}

})();