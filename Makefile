.PHONY: init install vite clean help watch

#colors
BWHITE=\033[47m
BGREEN=\033[48;5;22m
BRED=\033[48;5;88m
BBLUE=\033[44m
BPURPLE=\033[48;5;55m
BORANGE=\033[48;5;166m
BLACK=\033[1;30m
LYELLOW=\033[38;5;186m
GREEN=\033[38;5;28m
END_COLOUR=\033[0m

init: install vite

install:
	composer clear-cache
	composer update
	composer install
	npm install
	@echo "Dependencies installed!"

vite:
	@DHT_IS_DEV_ENVIRONMENT=$$(php config/makefile.php); \
    	if [ "$$DHT_IS_DEV_ENVIRONMENT" = "true" ]; then \
    		if [ "$(filter watch,$(MAKECMDGOALS))" ]; then \
    			npm run build:watch:vite; \
    		else \
    			npm run build:dev:vite; \
    		fi; \
    		echo "Assets Generated!"; \
    	else \
    		if [ ! "$(filter watch,$(MAKECMDGOALS))" ]; then \
    		  	npm run build:prod:vite; \
				echo "Assets Generated!"; \
    		fi; \
    	fi;


watch:
	@echo "Watch mode not available for Production mode!"; \


clean:
	@echo "Cleaning up..."
	node helpers/node/remove-js-generated-files.js
	@echo "Files Removed!"


help:
	@echo "$(BORANGE)>>>>>>>> Available commands: <<<<<<<<$(END_COLOUR)"
	@echo ""
	@echo "  $(BGREEN) make init $(END_COLOUR)         Install dependencies (Composer and NPM) and generate JS and CSS files"
	@echo ""
	@echo "  $(BBLUE) make install $(END_COLOUR)      Install dependencies (Composer and NPM)"
	@echo ""
	@echo "  $(BPURPLE) make vite [watch] $(END_COLOUR) Generate JS and CSS files:"
	@echo "                          	  $(LYELLOW)@param$(END_COLOUR) $(LYELLOW)watch$(END_COLOUR) - enable watch mode.\
 Will run only when $(LYELLOW)DHT_IS_DEV_ENVIRONMENT == true$(END_COLOUR) command"
	@echo "                                  <<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>"
	@echo "                                  -$(LYELLOW)DHT_IS_DEV_ENVIRONMENT == true$(END_COLOUR) + $(LYELLOW)watch$(END_COLOUR) run $(LYELLOW)npm run build:watch:vite$(END_COLOUR) command"
	@echo "                                  -$(LYELLOW)DHT_IS_DEV_ENVIRONMENT == true$(END_COLOUR)  run $(LYELLOW)npm run build:dev:vite$(END_COLOUR) command"
	@echo "                                  -$(LYELLOW)DHT_IS_DEV_ENVIRONMENT == false$(END_COLOUR) run $(LYELLOW)npm run build:prod:vite$(END_COLOUR) command"
	@echo "  $(BRED) make clean $(END_COLOUR)        Clean up the generated files"
	@echo ""
	@echo "  $(BWHITE)$(GREEN) make help $(END_COLOUR)$(END_COLOUR)         Show this help message"
	@echo ""