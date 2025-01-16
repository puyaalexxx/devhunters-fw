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

init: install vite

install:
	composer clear-cache
	composer update
	composer install
	npm install
	@echo ""
	@echo "$(LGREEN)Dependencies installed!$(END_COLOUR)"

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
	@echo "  $(BGREEN) make init $(END_COLOUR)         Install dependencies (Composer and NPM) and generate JS and CSS files"
	@echo ""
	@echo "  $(BBLUE) make install $(END_COLOUR)      Install dependencies (Composer and NPM)"
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