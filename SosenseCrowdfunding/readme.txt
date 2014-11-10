Plugin Name : Sosense Crowdfunding

Shortcode used in plugin:
1) [EDD-pricing-options id="any edd download id"  boxcolor="any color"  height="optional" ]
2) [ShowFundingstat]


General: This plugin is to show Sales Stats of the deals and Funding stat of deals.
		 This plugin support shortcode [showpayments] is used to show raised amount.
		 This plugin support shortcode [ShowFundingstat] is used to show funding stats of deals.
		 This plugin support shortcode [EDD-pricing-options id="any edd download id"  boxcolor="any color"  height="optional" ] is used to show Pricing option of EDD download.
		 
Technical Details:

-This plugin have widgets.php file. which has widget class "Child_Marketify_Widget_Download_Details";

-This widget having following options:

  -Title: you can add Heading in this.
  -Rename Goal to: To rename text 'Goal'
  -Rename Raised to: To rename text 'Raised'
  -Rename Purchases to: To rename text 'Purchases'
  -Rename Comments to: To rename text 'Comments'
  -Hide purchase count: To Hide counts of Purchase
  -Payment Status:here you can payment status to filter results of Raised amount and Purchase counts.
  
- This plugin have function.php file. which has all the function used in this plugin.
- This plugin have crowdfunding_details.php file. which is used Add Crowdfunding Details.
- This plugin have js folder . With this js Progress bar appears in funding stats and campaigning.js with this we pre-selected option for pop-up.
- This plugin have salesstyle.css and campaigning.css used to give style. 

How to use:
- We can use this widget in Deal's page only .
- Widget name is 'Sosense Sidebar Sales Stats'.
- Add sales goal under Crowdfunding Details
-Activate Sosense Sales Stats plugin.
-Add shortcode ( do_shortcode('[ShowFundingstat]') ) in shortcode-content-title.php.
-Add shortcode [EDD-pricing-options id="any edd download id"  boxcolor="any color"  height="optional" ] in any page.





	
  