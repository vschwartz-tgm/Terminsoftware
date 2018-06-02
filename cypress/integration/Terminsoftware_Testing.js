describe('Navigating the Sites', function() {
  it("Go to the register site", function() {
    cy.visit('https://terminreservierungssystem.herokuapp.com/src/login.php')

	cy.get('a').first().click()
	
    cy.url().should('include', '/src/signUp.php')
  })
})
