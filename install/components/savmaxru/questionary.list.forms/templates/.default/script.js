;(function()
{
	BX.namespace("BX.Vendor.ComponentName");

	BX.Vendor.ComponentName.BookList = function(options)
	{
		this.placeholder = options.placeholder;
		this.button = options.button;
		this.init();
	};

	BX.Vendor.ComponentName.BookList.prototype = {
		init: function()
		{
			this.button.addEventListener("click", this.onButtonClick.bind(this));
		},

		onButtonClick: function()
		{
			var id = +new Date();

			BX.Vendor.Extension.Book.get(id).then(function(result)
			{
				this.placeholder.innerText = JSON.stringify(result);
			});
		}
	}

})();