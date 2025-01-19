.PHONY: init install vite clean help

#colors
BWHITE=\033[47m
BGREEN=\033[48;5;22m
BRED=\033[48;5;88m
BBLUE=\033[44m
BPURPLE=\033[48;5;55m
BORANGE=\033[48;5;166m
BLACK=\033[1;30m
LYELLOW=\033[36m
LGREEN=\033[38;5;82m
GREEN=\033[38;5;28m
RED=\033[0;31m
END_COLOUR=\033[0m

include .env

# Install dependencies and assets based on environment
init:
	@echo "Installing dependencies and generating the assets..."
	@if [ "$(filter skip-composer,$(MAKECMDGOALS))" ]; then \
		if [ "${DHT_IS_DEV_ENVIRONMENT}" = "true" ]; then \
			make install-dev skip-composer && \
			npm run build; \
		else \
			make install-dev skip-composer && \
			npm run build:main && \
			make install-prod skip-composer; \
		fi; \
	else \
		if [ "${DHT_IS_DEV_ENVIRONMENT}" = "true" ]; then \
			make install-dev && \
			npm run build; \
		else \
			make install-dev && \
			npm run build:main && \
			make install-prod; \
		fi; \
	fi
	@echo ""
	@echo "$(LGREEN)Dependencies installed and assets generated!$(END_COLOUR)"


# Install dependencies based on environment
install:
	@echo "Installing dependencies..."
	@if [ "${DHT_IS_DEV_ENVIRONMENT}" = "true" ]; then \
		make install-dev; \
	else \
		make install-prod; \
	fi
	@echo ""
	@echo "$(LGREEN)Dependencies installed!$(END_COLOUR)"


install-dev:
	@if [ "$(filter skip-composer,$(MAKECMDGOALS))" ]; then \
  		npm install && \
		npm update devhunters-utils; \
	elif [ "$(filter skip-npm,$(MAKECMDGOALS))" ]; then \
		composer clear-cache && \
		composer update && \
		composer install; \
	else \
		composer clear-cache && \
		composer update && \
		composer install && \
		npm install && \
		npm update devhunters-utils; \
	fi


install-prod:
	@if [ "$(filter skip-composer,$(MAKECMDGOALS))" ]; then \
  		npm install --production; \
	elif [ "$(filter skip-npm,$(MAKECMDGOALS))" ]; then \
		composer clear-cache && \
		composer update --no-dev && \
		composer dump-autoload --optimize && \
		composer install --no-dev; \
	else \
		composer clear-cache && \
		composer update --no-dev && \
		composer dump-autoload --optimize && \
		composer install --no-dev && \
		npm install --production; \
	fi


vite:
	@if [ "$(filter watch,$(MAKECMDGOALS))" ]; then \
		if [ "$(filter main,$(MAKECMDGOALS))" ]; then \
			npm run watch:main; \
		else \
			npm run watch; \
		fi; \
		echo ""; \
		echo "$(LGREEN)Assets generated in watch mode!$(END_COLOUR)"; \
	else \
		if [ "$(filter main,$(MAKECMDGOALS))" ]; then \
			npm run build:main; \
		else \
			npm run build; \
		fi; \
		echo ""; \
		echo "$(LGREEN)Assets generated for development!$(END_COLOUR)"; \
	fi


clean:
	@echo "$(LGREEN)Cleaning up...$(END_COLOUR)"
	node helpers/node/remove-js-generated-files.js
	@echo ""
	@echo "$(RED)Files Removed!$(END_COLOUR)"


help:
	@echo "$(BBLUE)  Available commands:                                                                      $(END_COLOUR)"
	@echo ""
	@echo "  $(BGREEN) make init $(END_COLOUR)         Install dependencies (Composer and NPM) and generate JS and CSS files based on environment"
	@echo "                                  $(LYELLOW)@param$(END_COLOUR) $(LYELLOW)skip-composer$(END_COLOUR) - this will install only the NPM packages and "
	@echo "                                  skip the Composer packages."
	@echo ""
	@echo "  $(BBLUE) make install $(END_COLOUR)      Install dependencies (Composer and NPM) based on environment"
	@echo ""
	@echo "  $(BPURPLE) make vite [watch] $(END_COLOUR) Generate assets via the vite utility:"
	@echo "                          	  $(LYELLOW)@param$(END_COLOUR) $(LYELLOW)watch$(END_COLOUR) - enable watch mode."
	@echo "                          	  $(LYELLOW)@param$(END_COLOUR) $(LYELLOW)main$(END_COLOUR)  - compile all files into one main.css and main.js file"
	@echo "                                  ( using dynamic module loading )"
	@echo "  $(BRED) make clean $(END_COLOUR)        Clean up the generated files (js generated ones)"
	@echo "  		      ( if using tsc compiler, it will generate js files alongside ts files )"
	@echo ""
	@echo "  $(BWHITE)$(GREEN) make help $(END_COLOUR)$(END_COLOUR)         Show this help message"
	@echo ""


#commands for parameters to not display any errors and do anything
main:
	@true

skip-composer:
	@true

skip-npm:
	@true