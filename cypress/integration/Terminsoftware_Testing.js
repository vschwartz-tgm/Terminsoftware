restartBrowserBetweenSpecFiles: true

Cypress.on('uncaught:exception', (err, runnable) => {
  // returning false here prevents Cypress from
  // failing the test
  return false
})

describe('Navigating the Sites', function() {
	it.skip("Go to the register site", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[href="signUp.php"]').first().click()
		
		cy.url().should('include', '/src/signUp.php')
	})
	it.skip("Leave the register site on cancel", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[href="signUp.php"]').first().click()
		
		cy.get('Button').contains('Cancel').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it.skip("Stay on the register site on Sign Up with empty Textfields", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[href="signUp.php"]').first().click()
		
		cy.get('button').contains('Sign Up').first().click()

		cy.url().should('include', '/src/signUp.php')
	})
	it.skip("Leave the register site on Sign Up", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[href="signUp.php"]').first().click()
		
		cy.get('[id="uname"]').first().type('Tester')
		cy.get('[id="email"]').first().type('tester@testing.com')
		cy.get('[id="psw"]').first().type('tests')
		cy.get('[id="psw-repeat"]').first().type('tests')
		
		cy.get('button').contains('Sign Up').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it.skip("Stay on the register site on Sign up with existing user", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('a').contains('Sign Up').first().click()
		
		cy.get('[id="uname"]').first().type('Tester')
		cy.get('[id="email"]').first().type('tester@testing.com')
		cy.get('[id="psw"]').first().type('tests')
		cy.get('[id="psw-repeat"]').first().type('tests')
		
		cy.get('button').contains('Sign Up').first().click()

		cy.url().should('include', 'src/signUp.php')
	})
	it.skip("Enter main site via successful login", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.url().should('include', '/src/terminreservierung.php')
	})
	it.skip("Stay on login site via failed login", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('button').contains('Login').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it.skip("Enter searchView", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('input').first().type('test')
		cy.get('button').contains('Search').first().click()
		
		cy.url().should('include', '/src/searchView.php')
	})
	it.skip("Stay on main site via failed search", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.get('input').first().click()
		
		cy.get('button').contains('Search').first().click()
		
		cy.url().should('include', '/src/terminreservierung.php')
	})
	it.skip("Have to be logged in to enter main site", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/terminreservierung.php')

		cy.get('a').contains('einloggen')
	})
	it.skip("Leave main site via logout", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.get('button').contains('Logout').first().click()
		
		cy.url().should('include', '/src/login.php')
	})
	it.skip("Leave searchView via logout", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('input').first().type('test')
		cy.get('button').contains('Search').first().click()
		
		cy.get('button').contains('Logout').first().click()
		
		cy.url().should('include', '/src/login.php')
	})
	it.skip("Enter newEvent", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.url().should('include', '/src/newEvent.php')
	})
	it.skip("leave newEvent via logout", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('Logout').first().click()
		cy.url().should('include', '/src/login.php')
	})
	it.skip("leave newEvent via cancel", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('Abbrechen').first().click()
		cy.url().should('include', '/src/terminreservierung.php')
	})
	it.skip("Stay on newEvent via failed add", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		

		cy.get('[id="submit"]').click()

		cy.url().should('include', '/src/newEvent.php')
	})
	it.skip("Leave newEvent via successful add", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[id="eventName"]').type('testblabla')
		cy.get('[id="date"]').type('01.01.2001 10:10')
		cy.get('[id="location"]').type('testing location')
		cy.get('[id="desc"]').type('ein test')
		cy.get('[id="people[]"]').type('tester')
		
		cy.get('[id="submit"]').click()

		cy.url().should('include', '/src/terminreservierung.php')
	})
	it.skip("Stay on newEvent via adding an existing event", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[id="eventName"]').type('testblabla')
		cy.get('[id="date"]').type('01.01.2001 10:10')
		cy.get('[id="location"]').type('testing location')
		cy.get('[id="desc"]').type('ein test')
		cy.get('[id="people[]"]').type('tester')
		
		cy.get('[id="submit"]').click()

		cy.url().should('include', '/src/newEvent.php')
	})
	it.skip("Add another date textfield via pressing the add date textfields button", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('+').first().click()
		
		cy.get('[id="date2"]')
	})
	it.skip("Add another date textfield via pressing the add date textfield button and then removing it via the remove date textfield button", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('+').first().click()
		
		cy.get('button').contains('-').first().click()
		cy.get('[id="date2"]').should('not.exist')
	})
	it.skip("pressing the remove date textfield button can not reduce the number of date textfields to 0", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('-').first().click()
		
		cy.get('[id="date"]')
	})
	it("Add another people textfield via pressing the add people textfields button", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[onclick="addPeople()"]').click()
		
		cy.get('[id="people2"]')
	})
	it("Add another people textfield via pressing the add people textfield button and then removing it via the remove people textfield button", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[onclick="addPeople()"]').click()
		
		cy.get('[onclick="removePeople(\'people\'+count_people)"]').click()
		
		cy.get('[id="people2"]').should('not.exist')
	})
	it("pressing the remove people textfield button can not reduce the number of people textfields to 0", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[onclick="removePeople(\'people\'+count_people)"]').click()
		
		cy.get('[id="people[]"]')
	})
})