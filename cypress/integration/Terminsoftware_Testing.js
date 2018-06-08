restartBrowserBetweenSpecFiles: true
video: true

Cypress.on('uncaught:exception', (err, runnable) => {
  // returning false here prevents Cypress from
  // failing the test
  return false
})

describe('Navigating the Sites', function() {
	it("Go to the register site", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[href="signUp.php"]').first().click()
		
		cy.url().should('include', '/src/signUp.php')
	})
	it("Leave the register site on cancel", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[href="signUp.php"]').first().click()
		
		cy.get('Button').contains('Cancel').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it("Stay on the register site on Sign Up with empty Textfields", function() {
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
	it("Stay on the register site on Sign up with existing user", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('a').contains('Sign Up').first().click()
		
		cy.get('[id="uname"]').first().type('Tester')
		cy.get('[id="email"]').first().type('tester@testing.com')
		cy.get('[id="psw"]').first().type('tests')
		cy.get('[id="psw-repeat"]').first().type('tests')
		
		cy.get('button').contains('Sign Up').first().click()

		cy.url().should('include', 'src/signUp.php')
	})
	it("Enter main site via successful login", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.url().should('include', '/src/terminreservierung.php')
	})
	it("Stay on login site via failed login", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('button').contains('Login').first().click()

		cy.url().should('include', '/src/login.php')
	})
	it("Enter searchView", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('input').first().type('test')
		cy.get('button').contains('Search').first().click()
		
		cy.url().should('include', '/src/searchView.php')
	})
	it("Stay on main site via failed search", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.get('input').first().click()
		
		cy.get('button').contains('Search').first().click()
		
		cy.url().should('include', '/src/terminreservierung.php')
	})
	it("Have to be logged in to enter main site", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/terminreservierung.php')

		cy.get('a').contains('einloggen')
	})
	it("Leave main site via logout", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.get('button').contains('Logout').first().click()
		
		cy.url().should('include', '/src/login.php')
	})
	it("Leave searchView via logout", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('input').first().type('test')
		cy.get('button').contains('Search').first().click()
		
		cy.get('button').contains('Logout').first().click()
		
		cy.url().should('include', '/src/login.php')
	})
	it("Enter newEvent", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.url().should('include', '/src/newEvent.php')
	})
	it("leave newEvent via logout", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('Logout').first().click()
		cy.url().should('include', '/src/login.php')
	})
	it("leave newEvent via cancel", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('Abbrechen').first().click()
		cy.url().should('include', '/src/terminreservierung.php')
	})
	it("Stay on newEvent via failed add", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[id="submit"]').click()

		cy.url().should('include', '/src/newEvent.php')
	})
	it("Leave newEvent via successful add", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[id="eventName"]').type('testblablabla')
		cy.get('[id="date"]').type('01.01.2001 10:10')
		cy.get('[id="location"]').type('testing location')
		cy.get('[id="desc"]').type('ein test')
		cy.get('[id="people[]"]').type('tester')
		
		cy.get('[id="submit"]').click()

		cy.url().should('include', '/src/terminreservierung.php')
	})
	it("Stay on newEvent via adding an existing event", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[id="eventName"]').type('testblablabla')
		cy.get('[id="date"]').type('01.01.2001 10:10')
		cy.get('[id="location"]').type('testing location')
		cy.get('[id="desc"]').type('ein test')
		cy.get('[id="people[]"]').type('tester')
		
		cy.get('[id="submit"]').click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('[id="eventName"]').type('testblabla')
		cy.get('[id="date"]').type('01.01.2001 10:10')
		cy.get('[id="location"]').type('testing location')
		cy.get('[id="desc"]').type('ein test')
		cy.get('[id="people[]"]').type('tester')
		
		cy.get('[id="submit"]').click()
		cy.url().should('include', '/src/newEvent.php')
	})

})

describe('Event', function() {
	it("add a new Event", function() {
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
	})
	it("Add another date textfield via pressing the add date textfields button", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('+').first().click()
		
		cy.get('[id="date2"]')
	})
	it("Add another date textfield via pressing the add date textfield button and then removing it via the remove date textfield button", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('button').contains('Add Event').first().click()
		
		cy.get('button').contains('+').first().click()
		
		cy.get('button').contains('-').first().click()
		cy.get('[id="date2"]').should('not.exist')
	})
	it("pressing the remove date textfield button can not reduce the number of date textfields to 0", function() {
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
	it("Event appears on the main site once created", function() {
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
		cy.once
		cy.get('[href ="terminreservierung.php?erstEvent=testblabla"]')
	})
	it("Can look at Event by klicking on it", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.get('[href ="terminreservierung.php?erstEvent=testblabla"]').contains('testblabla').click()
		
		cy.url().should('include', '/src/eventView_Ersteller.php')
	})
	it("Can leave the event you're currently looking at", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()

		cy.get('[href ="terminreservierung.php?erstEvent=testblabla"]').contains('testblabla').click()
		
		cy.get('[value="Zurück"]').click()
		
		cy.url().should('include', '/src/terminreservierung.php')
	})
	it("Event doesn't show up on main site once deleted", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()


		cy.get('[href ="terminreservierung.php?erstEvent=testblabla"]').contains('testblabla ').click()
		
		cy.get('[value="Event löschen"]').click()
		
		cy.get('[href ="terminreservierung.php?erstEvent=testblabla"]').should('not.exist')
	})
})
describe('search', function() {
	it("searchView shows searched events", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('input').first().type('test')
		cy.get('button').contains('Search').first().click()
		
		cy.get('a').contains('test')
	})
	it("searchView shows searched user", function() {
		cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')
		
		cy.get('[name="uname"]').first().type('Tester')
		cy.get('[name="psw"]').first().type('tests')
		
		cy.get('button').contains('Login').first().click()
		
		cy.get('label').contains('User').click()
		cy.get('input').first().type('Tester')
		cy.get('button').contains('Search').first().click()
		
		cy.get('td').contains('Tester')
	})
})