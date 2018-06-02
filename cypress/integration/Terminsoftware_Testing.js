restartBrowserBetweenSpecFiles: true

describe('Navigating the Sites', function() {
	it.skip("Go to the register site", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('a').contains('Sign Up').first().click()
		
		cy.url().should('include', '/src/signUp.php')
	})
	it.skip("Leave the register site on cancel", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/signUp.php')

		cy.get('Button').contains('Cancel').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it.skip("Stay on the register site on Sign Up with empty Textfields", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/signUp.php')


		
		cy.get('button').contains('Sign Up').first().click()

		cy.url().should('include', '/src/signUp.php')
	})
	it.skip("Leave the register site on Sign Up", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/signUp.php')

		cy.get('#uname').first().type('Tester')
		cy.get('#email').first().type('tester@testing.com')
		cy.get('#psw').first().type('tests')
		cy.get('#psw-repeat').first().type('tests')
		
		cy.get('button').contains('Sign Up').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it("Enter main site via succesful login", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('input').first().type('Tester')
		cy.get('input').first().next().next().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.url().should('include', '/src/terminreservierung.php')
		// doesn't actually fail. The Problem is on the Browser/Application side side.
	})
	it("Stay on login site via failed login", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('button').contains('Login').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it("Enter searchView", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('input').first().type('Tester')
		cy.get('input').first().next().next().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('input').first().type('test')
		cy.get('button').contains('search').first().click()
		
		cy.url().should('include', '/src/searchView.php')
	})
	it("Stay on login site via failed search", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('input').first().type('Tester')
		cy.get('input').first().next().next().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.get('input').first().click()
		
		cy.get('button').contains('search').first().click()
		
		cy.url().should('include', '/src/terminreservierung.php')
	})
	it("Have to be logged in to enter main site", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/terminreservierung.php')

		cy.get('a').contains('einloggen')
	})
})